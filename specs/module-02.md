## Objective
Build the document upload feature so teachers can submit files (lesson plans, forms, reports, other) with a document type label.

## Context
Auth is complete. Two roles exist: teacher, admin. Stack: Laravel 12, Tailwind CSS.

## Target State
- `documents` table: id, user_id (teacher), title, type (enum: lesson_plan, form, report, other), file_path, status (enum: draft, submitted, under_review, reviewed, needs_revision — default: draft), timestamps
- `DocumentController` with `create`, `store` methods (teacher-only)
- Upload form: title input, type dropdown, file input (PDF, DOC, DOCX, max 10MB), submit button
- Files stored in `storage/app/private/documents/{user_id}/`
- On store: status set to `submitted`, triggers a submission event (stub the event class, listener wired but body empty — filled in Module 5)