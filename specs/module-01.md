## Objective
Scaffold role-based authentication for two user types: Teacher and Admin/Supervisor.

## Target State
- `users` table with a `role` column (enum: teacher, admin)
- Login and registration pages styled with Tailwind (minimal, no cards with heavy shadows, clean form inputs)
- Route middleware `role:admin` and `role:teacher` protecting their respective areas
- Redirect after login: admins → /admin/dashboard, teachers → /teacher/dashboard
- Stub dashboard views for each role (empty layout, just a heading)