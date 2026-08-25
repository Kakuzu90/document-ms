## Objective
Allow a teacher to replace the file on an existing document when its status is either `submitted`
or `needs_revision` — covering both the "wrong file attached" correction case and the
"admin requested changes" revision case.

## Context
Module 2 is complete (document upload). Documents table has: file_path, status.
Status enum: draft, submitted, under_review, reviewed, needs_revision.
Teachers can currently upload new documents but cannot update an existing one.
Module 5 notifications are in place — DocumentSubmitted event is dispatched on original upload.

## Target State

Revision upload form (/teacher/documents/{document}/revise):
- Shows: document title, current status badge
- When status=needs_revision: list admin comments read-only below the heading so the teacher
  sees what to fix. When status=submitted: omit the comments section.
- File input: PDF, DOC, DOCX, max 10MB (same validation as Module 2)
- Optional note textarea: "Note" (nullable, max 500 chars), saved as a Comment attributed
  to the teacher. Placeholder text:
    status=needs_revision → "Describe what you changed…"
    status=submitted      → "Reason for replacing file (optional)…"
- Submit button label:
    status=needs_revision → "Submit Revision"
    status=submitted      → "Replace File"
- Cancel link: back to /teacher/documents/{document}

Access guard:
- Only the document's owner (teacher) may access this route — abort(403) otherwise.
- Allowed statuses: `submitted` and `needs_revision` only.
- If document status is `under_review`, `reviewed`, or `draft`, redirect to
  /teacher/documents/{document} with flash error:
    under_review → "This document is currently under review and cannot be changed."
    reviewed     → "This document has been reviewed and cannot be changed."
    draft        → "Draft documents use the standard upload form."
- Do not use a single generic error message — use status-specific messages as above.

On POST (store replacement):
1. Validate file (required, mimes:pdf,doc,docx, max:10240) and note (nullable, max:500)
2. Store new file as documents/{user_id}/{original_filename}_revised_{timestamp}.ext
   in the local private disk — do NOT delete the original file_path
3. Update documents.file_path to the new file path
4. If note is not empty: save as a Comment (document_id, user_id=teacher, body=note)
5. Status behaviour:
   - If previous status was `needs_revision`: reset to `submitted`, dispatch DocumentSubmitted event
   - If previous status was `submitted`: keep status as `submitted`, dispatch DocumentSubmitted event
   (In both cases the event signals the admin to (re-)review)
6. Redirect to /teacher/documents with flash: "Your file has been updated."

Teacher document list (/teacher/documents):
- Add a "Replace File" action link on rows where status=submitted
- Add a "Revise" action link on rows where status=needs_revision
- Both link to /teacher/documents/{document}/revise
- Style: same as existing action links in the table

Teacher document detail view (/teacher/documents/{document}):
- Add an "Update File" button when status=submitted, linking to the revise route
- Add an "Upload Revision" button when status=needs_revision, linking to the revise route


## Constraints
- New controller handles only revise (show + store). Do not add methods for other actions.
- Authorization: manual check — if auth()->id() !== $document->user_id, abort(403).
  Do not create a Policy class unless one already exists for Document.
- Do not delete the original file — only update the file_path column to point to the new file.
- DocumentSubmitted event must be dispatched for both allowed statuses — do not create a
  new event class.
- Status-specific error messages are required — do not collapse them into one generic message.