<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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

        return view('admin.dashboard', compact('stats', 'actionRequired', 'recentlyReviewed'));
    }
}
