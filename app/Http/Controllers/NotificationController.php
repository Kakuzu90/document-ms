<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Mark a notification as read and redirect to the relevant resource.
     */
    public function read(Request $request, string $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);

        $notification->markAsRead();

        $documentId = $notification->data['document_id'] ?? null;

        if ($documentId) {
            $route = $request->user()->isAdmin() ? 'admin.documents.show' : 'teacher.documents.show';
            return redirect()->route($route, $documentId);
        }

        return redirect()->route($request->user()->dashboardRoute());
    }
}
