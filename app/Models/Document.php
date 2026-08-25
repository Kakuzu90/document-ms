<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'type',
        'file_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'type' => \App\Enums\DocumentType::class,
            'status' => \App\Enums\DocumentStatus::class,
        ];
    }

    /**
     * Get the user that owns the document.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the document.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the status histories for the document.
     */
    public function statusHistories(): HasMany
    {
        return $this->hasMany(StatusHistory::class);
    }

    /**
     * Check if the document is not reviewed.
     */
    public function isNotReviewed(): bool
    {
        return $this->status !== \App\Enums\DocumentStatus::REVIEWED;
    }

    /**
     * Scope a query to search by title or user name.
     */
    public function scopeSearch(\Illuminate\Database\Eloquent\Builder $query, ?string $search): \Illuminate\Database\Eloquent\Builder
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhereHas('user', function ($uq) use ($search) {
                  $uq->where('name', 'like', '%' . $search . '%');
              });
        });
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeFilterStatus(\Illuminate\Database\Eloquent\Builder $query, ?string $status): \Illuminate\Database\Eloquent\Builder
    {
        if (!$status) {
            return $query;
        }

        return $query->where('status', $status);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeFilterType(\Illuminate\Database\Eloquent\Builder $query, ?string $type): \Illuminate\Database\Eloquent\Builder
    {
        if (!$type) {
            return $query;
        }

        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by submission date range.
     */
    public function scopeSubmittedBetween(\Illuminate\Database\Eloquent\Builder $query, ?string $from, ?string $to): \Illuminate\Database\Eloquent\Builder
    {
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        return $query;
    }
}
