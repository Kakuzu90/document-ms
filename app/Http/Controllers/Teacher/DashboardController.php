<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // 1. Stats Query
        // Get counts grouped by status for the teacher
        $statusCounts = $user->documents()
            ->where('status', '!=', DocumentStatus::DRAFT->value)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'total_submitted' => $statusCounts->sum(),
            'approved' => $statusCounts[DocumentStatus::REVIEWED->value] ?? 0,
            'needs_revision' => $statusCounts[DocumentStatus::NEEDS_REVISION->value] ?? 0,
        ];

        // 2. Action Required: All documents needing revision
        $actionRequired = $user->documents()
            ->where('status', DocumentStatus::NEEDS_REVISION->value)
            ->latest()
            ->get();

        // 3. Reviewed Table: 5 most recently reviewed documents
        $recentlyReviewed = $user->documents()
            ->whereIn('status', [DocumentStatus::REVIEWED->value, DocumentStatus::NEEDS_REVISION->value])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact('stats', 'actionRequired', 'recentlyReviewed'));
    }
}
