<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\DocumentStatus;
use App\Enums\DocumentType;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Document::class);

        $query = Document::with('user')->where('status', '!=', DocumentStatus::DRAFT->value);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();
        
        $statuses = DocumentStatus::cases();
        $types = DocumentType::cases();

        return view('admin.documents.index', compact('documents', 'statuses', 'types'));
    }
}
