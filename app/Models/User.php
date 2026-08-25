<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\UserRole;
use App\Enums\UserStatus;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'last_seen_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'status' => UserStatus::class,
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Determine if the user is an administrator/supervisor.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    /**
     * Determine if the user is a teacher.
     */
    public function isTeacher(): bool
    {
        return $this->role === UserRole::TEACHER;
    }

    /**
     * Determine if the user is inactive.
     */
    public function isInActive(): bool
    {
        return $this->status === UserStatus::Inactive;
    }

    /**
     * The route name of the dashboard for this user's role.
     */
    public function dashboardRoute(): string
    {
        return $this->isAdmin() ? 'admin.dashboard' : 'teacher.dashboard';
    }

    /**
     * Get the documents for the user.
     */
    public function documents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Determine if the user is currently online.
     */
    public function isOnline(): bool
    {
        return $this->last_seen_at !== null && $this->last_seen_at->diffInMinutes(now()) < 5;
    }

    /**
     * Mark unread notifications for a specific document as read.
     */
    public function markDocumentNotificationsAsRead(Document $document): void
    {
        $this->unreadNotifications()
            ->whereJsonContains('data->document_id', $document->id)
            ->update(['read_at' => now()]);
    }
}
