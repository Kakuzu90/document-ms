## Objective
Implement in-app notifications for two events: teacher submits → admin notified; admin reviews → teacher notified.

## Context
DocumentSubmitted event exists (stub from Module 2). Auth, documents, and comments are complete.
Stack: Laravel 12, Tailwind CSS.

## Target State
- `notifications` table via Laravel's built-in `php artisan notifications:table`
- Two notification classes:
  1. `DocumentSubmittedNotification` — sent to all admin users when a teacher submits
  2. `DocumentReviewedNotification` — sent to the document's teacher when an admin marks status as `reviewed` or `needs_revision`
- Notification bell icon in the nav (top-right), showing unread count badge
- Clicking the bell shows a dropdown of the last 10 notifications (title, timestamp, link to document)
- Clicking a notification marks it as read and redirects to the document

## Constraints
- Use Laravel's database notification channel only.
- No real-time (no Pusher, Echo, or websockets). Poll or page-refresh only.
- Only make changes directly requested. Do not add email, SMS, or push.