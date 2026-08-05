## Objective
Build the submission history views for both teachers and admins, showing document status with visual indicators.

## Context
Documents table exists with status enum: draft, submitted, under_review, reviewed, needs_revision.
Auth and upload are complete. Stack: Laravel 12, Tailwind CSS.

## Target State
Teacher side (/teacher/documents):
- Table listing their own documents: title, type, status badge, submitted date, action link (view)

Admin side (/admin/documents):
- Table listing all submitted documents: teacher name, title, type, status, date, action link
- Filter bar: filter by status, filter by type (HTML selects, no JS framework)
- Pagination on both views (Laravel default paginator)