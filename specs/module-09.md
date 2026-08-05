## Objective
Allow admins to manually update a document's status from the document detail view, full audit history, and existing notification dispatch preserved.

## Context
Admin document detail view exists at /admin/documents/{document}.
Current status enum on documents: draft, submitted, under_review, reviewed, needs_revision.
DocumentReviewedNotification (Module 5) already fires when status becomes reviewed or needs_revision — it must continue to fire unchanged.

## Target State
New migration — status_histories table:
- id, document_id (FK), changed_by (FK → users.id), from_status (string), to_status (string), created_at (no updated_at)

Status update panel on admin document detail view:
- Position: below document metadata, above comments section
- Label: "Update Status"
- Select showing: submitted, under_review, reviewed, needs_revision
- Pre-selected to current document status
- Submit button: "Update Status"

On submit:
- If new status === current status: redirect back, flash info message "Status is already set to [status]", no DB write
- If status changed:
  1. Update documents.status
  2. Write one status_histories row (from, to, changed_by)
  3. If to_status is reviewed or needs_revision: dispatch DocumentReviewedNotification to the teacher
  4. Redirect back to the document detail view with success flash

Status history panel on admin document detail view:
- Below the update form
- Rows: "From [X] → [Y]", changed by admin name, date
- Oldest first

## Constraints
- Validation: status required|in:submitted,under_review,reviewed,needs_revision.
- draft is not a valid selectable status and must be rejected by validation.
- Only make changes directly requested. Do not add bulk updates or a visual status timeline.