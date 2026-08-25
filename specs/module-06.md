## Objective
Add search and filtering to the admin document list and teacher document list.

## Context
Document list views exist for both roles (from Module 3). Stack: Laravel 12, Tailwind CSS.

## Target State
Admin document list:
- Search bar (searches title, teacher name)
- Filters: status (select), type (select), date range (two date inputs: submitted_from, submitted_to)
- Results update on form submit (GET, no JS required)

Teacher document list:
- Search bar (searches own document titles)
- Filter by status (select), filter by type (select)

Both lists: show "No documents found" state when results are empty (clean empty state, not just an empty table).

## Constraints
- All filtering via Eloquent query builder in the controller. No raw SQL.
- No JavaScript, no AJAX. Plain GET form submission.
- Preserve pagination with filters (append query string to paginator links).
- Only make changes directly requested.