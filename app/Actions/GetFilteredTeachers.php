<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class GetFilteredTeachers
{
    public function handle(array $filters): LengthAwarePaginator
    {
        $query = User::where('role', UserRole::TEACHER)
            ->withCount('documents')
            ->latest();

        if (!empty($filters['search'])) {
            $query->whereAny(['name', 'email'], 'LIKE', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['status']) && \App\Enums\UserStatus::tryFrom($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['joined_date'])) {
            $query->whereDate('created_at', $filters['joined_date']);
        }

        return $query->paginate(20)->withQueryString();
    }
}
