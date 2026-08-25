## Objective
Add a Teachers section to the admin navigation that lists all teacher accounts and allows the admin to update each teacher's editable fields: status (active/inactive), name, and email.

## Context
Auth complete. Users table has: id, name, email, password, role (enum: teacher, admin), timestamps.
No `status` column exists on users yet — add it via a new migration.

## Target State
Migration:
- Add `status` column to `users` table: enum('active', 'inactive'), default 'active'

Routes (admin-only):
- GET  /admin/teachers              → index (paginated list of all teachers)
- GET  /admin/teachers/{user}       → show (read-only profile + document summary)
- GET  /admin/teachers/{user}/edit  → edit form
- PUT  /admin/teachers/{user}       → update

Teacher index view (/admin/teachers):
- Table columns: Name, Email, Status badge, Joined date, Document count, Actions (Edit | View)
- Status badge: active=, inactive=
- Paginate at 20 per page

Teacher edit view (/admin/teachers/{user}/edit):
- Fields: Name (text), Email (email), Status (select: active / inactive)
- Submit: "Save Changes"
- Cancel link back to index
- Validation via Form Request (UpdateTeacherRequest):
  name required|max:255, email required|email|unique:users,email,{id}, status required|in:active,inactive

Teacher show view (/admin/teachers/{user}):
- Display: name, email, status badge, joined date
- Table of their submitted documents: title, type, status badge, submitted date (last 10, no pagination)
- "Edit" button linking to the edit form


## Constraints
- Route model binding {user} scoped to role=teacher: filter in the controller (findOrFail with where role=teacher), not via global binding changes.
- If the resolved user is not a teacher, return 403.
- Admin cannot change a teacher's role via this form — role field must be ignored even if submitted.
- Admin cannot edit another admin's profile via this route (403 if user->role !== teacher).
- Only make changes directly requested. Do not add password reset, impersonation, or deletion.