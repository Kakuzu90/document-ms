## Objective
Add a dedicated notifications page listing all of a user's notifications, and automatically mark
a notification as read when the user opens the linked document while that notification is unread.

## Context
Module 5 is complete. Laravel database notifications are in place (notifications table).
Bell icon in nav shows unread count; clicking a notification marks it read and redirects.

## Target State
Notifications page:
- Route: GET /notifications → NotificationController@index (accessible to both roles)
- View: resources/views/notifications/index.blade.php
- Lists ALL notifications for the authenticated user, newest first, paginated at 20
- Each row: icon dot (filled [color]-800 = unread, hollow [color]-300 = read), title/description text,
  relative timestamp (e.g. "2 hours ago" — use Carbon::diffForHumans()), link to the document
- "Mark all as read" button at the top-right of the page — POST /notifications/read-all
  Marks all unread notifications as read; redirects back to the page
- Empty state: "You have no notifications." in [color]-400, centred
- Nav bell "See all" link at the bottom of the dropdown pointing to /notifications

Auto-read on document view:
- When any user visits a document detail view (/admin/documents/{document} or
  /teacher/documents/{document}), find any unread notification belonging to that user that
  references the same document (check notifiable_id = auth()->id() AND
  data->document_id = $document->id AND read_at IS NULL) and mark it read immediately
- Implement this in the relevant show() methods (AdminDocumentController and
  TeacherDocumentController) — one line using:
  auth()->user()->unreadNotifications()->whereJsonContains('data->document_id', $document->id)->update(['read_at' => now()])
- No redirect, no flash — silent background operation

## Scope
- Work only in: app/Http/Controllers/NotificationController.php (add index + markAllRead methods),
  resources/views/notifications/index.blade.php (new),
  resources/views/layouts/app.blade.php (bell "See all" link only),
  app/Http/Controllers/Admin/DocumentController.php (show method — auto-read line only),
  app/Http/Controllers/Teacher/DocumentController.php (show method — auto-read line only),
  routes/web.php
- Do NOT touch: notification classes, bell dropdown HTML beyond adding the "See all" link,
  any migration

## Constraints
- "Mark all as read" must use a POST route with CSRF — not a GET link.
- Auto-read must not redirect or flash — it is a silent DB update only.
- Do not install Carbon separately — it is already available in Laravel 12.
- Only make changes directly requested. Do not add per-notification delete or a read filter tab.