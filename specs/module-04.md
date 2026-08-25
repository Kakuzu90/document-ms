## Objective
Allow admins to leave comments on a document, and teachers to read those comments.

## Context
Documents exist with a detail view. Auth complete. Stack: Laravel 12, Tailwind CSS.

## Target State
- `comments` table: id, document_id, user_id, body (text), created_at
- Comment form visible only to admins on the document detail view
- Comments listed below the document info (oldest first), showing commenter name, timestamp, body
- Teachers see comments on their document detail view (read-only, no form)
- After an admin posts a comment, status updates to `under_review` if it was `submitted`

## Constraints
- Plain Blade forms only, no AJAX or Livewire.
- Comment body: required, min:5, max:2000.
- Soft delete is NOT needed.
- Only make changes directly requested.