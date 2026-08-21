<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 0. Teacher counts (single grouped query)
        $teacherStatusCounts = User::where('role', 'teacher')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalTeachers = $teacherStatusCounts->sum();
        $teacherCounts = [
            'active' => $teacherStatusCounts['active'] ?? 0,
            'inactive' => $teacherStatusCounts['inactive'] ?? 0,
        ];

        // 1. Stats Query
        // Get counts grouped by status (excluding drafts)
        $statusCounts = Document::where('status', '!=', DocumentStatus::DRAFT->value)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'total_submitted' => $statusCounts->sum(),
            'under_review' => $statusCounts[DocumentStatus::UNDER_REVIEW->value] ?? 0,
            'approved' => $statusCounts[DocumentStatus::REVIEWED->value] ?? 0,
            'needs_revision' => $statusCounts[DocumentStatus::NEEDS_REVISION->value] ?? 0,
        ];

        // 2. Action Table: 5 most recent submissions needing action
        $actionRequired = Document::with('user')
            ->whereIn('status', [DocumentStatus::SUBMITTED->value, DocumentStatus::UNDER_REVIEW->value])
            ->latest()
            ->take(5)
            ->get();

        // 3. Reviewed Table: 5 most recently reviewed documents
        $recentlyReviewed = Document::with('user')
            ->whereIn('status', [DocumentStatus::REVIEWED->value, DocumentStatus::NEEDS_REVISION->value])
            ->latest('updated_at')
            ->take(5)
            ->get();

        // 4. Storage Space
        $storagePath = storage_path('app');
        $totalSpace = @disk_total_space($storagePath) ?: 1;
        $freeSpace = @disk_free_space($storagePath) ?: 0;
        $usedSpace = $totalSpace - $freeSpace;
        $usedPercentage = min(100, round(($usedSpace / $totalSpace) * 100, 2));

        $formatBytes = function ($bytes) {
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes /= (1 << (10 * $pow));
            return round($bytes, 2) . ' ' . $units[$pow];
        };

        $storageInfo = [
            'total' => $formatBytes($totalSpace),
            'used' => $formatBytes($usedSpace),
            'free' => $formatBytes($freeSpace),
            'percentage' => $usedPercentage,
        ];

        return view('admin.dashboard', compact('stats', 'totalTeachers', 'teacherCounts', 'actionRequired', 'recentlyReviewed', 'storageInfo'));
    }
}
