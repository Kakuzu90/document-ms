## Objective
Add a search bar and filter controls to the admin teacher list (/admin/teachers) so admins can
narrow the list by name/email keyword and by account status.

## Context
Module 9 is complete. Admin teacher index at /admin/teachers shows a paginated table of all
teacher accounts with columns: Name, Email, Status badge, Joined date, Document count, Actions.
Filtering already exists on the document list (Module 7) — follow the same GET query string pattern.

## Target State
Filter bar above the teacher table:
- Search input: placeholder "Search by name or email…", searches users.name and users.email
  (case-insensitive LIKE on both columns, OR logic)
- Status filter: select with options — All, Active, Inactive
- "Search" submit button
- "Clear" link that resets to /admin/teachers (plain text link, no button chrome)
- Active filter values must persist in the inputs after submission (re-populate from query string)

Pagination:
- Paginator links must carry the current search and status query string (->appends(request()->query()))

Empty state:
- When no teachers match the filter, show: "No teachers found for the current filters."

TeacherController@index update:
- Apply search: when `search` param present, add whereAny(['name','email'],'LIKE',"%{search}%")
  or equivalent chained orWhere — no raw SQL
- Apply status filter: when `status` param is `active` or `inactive`, add where('status', $status)
- Exclude admin-role users regardless of filters (role=teacher always scoped)

## Constraints
- All filtering via Eloquent query builder — no raw SQL, no Scout/Meilisearch.
- Plain Blade + GET form — no Alpine, no Livewire, no JavaScript.
- Preserve pagination with filters: use ->appends(request()->query()) on the paginator.