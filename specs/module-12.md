## Objective
Add a "Total Teachers" stat card to the admin dashboard alongside the existing submission stat cards.

## Context
Module 8 is complete. Admin dashboard at /admin/dashboard has 4 stat cards:
Total Submitted, Under Review, Reviewed/Approved, Needs Revision.
Module 9 added a users.status column (enum: active, inactive).

## Target State
Admin dashboard stat card row — add one new card:
- Label: "Total Teachers"
- Value: count of users where role=teacher (all statuses combined)
- Sub-label: two smaller counts below the main number:
    "X active"  · "Y inactive"
  separated by a mid-dot (·) on a single line
- Card style: matches existing stat cards exactly
- Position: first card in the row, before "Total Submitted"

DashboardController update:
- Add two new variables passed to the admin dashboard view:
    $totalTeachers  — User::where('role','teacher')->count()
    $teacherCounts  — ['active' => ..., 'inactive' => ...]  (one query using groupBy or two counts)
- Use withCount or separate queries — no N+1

## Constraints
- No new route. No new model scope unless a one-liner local scope is the cleanest option.
- The two sub-counts must come from the DB, not hardcoded.
- Do not remove or reorder the existing 4 stat cards.
- Only make changes directly requested. Do not add a teachers chart or trend indicator.