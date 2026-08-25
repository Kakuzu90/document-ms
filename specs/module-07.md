## Objective
Build role-specific dashboards showing summary stats and quick-access lists for pending and completed submissions.

## Context
All core features are complete. Stack: Laravel 12, Tailwind CSS.

## Target State
Admin dashboard (/admin/dashboard):
- Stat cards (4): Total Submitted, Under Review, Reviewed/Approved, Needs Revision
- Table: 5 most recent submissions needing action (status = submitted or under_review), with teacher name, title, type, date, link
- Table: 5 most recently reviewed documents

Teacher dashboard (/teacher/dashboard):
- Stat cards (3): Total Submitted, Reviewed/Approved, Needs Revision
- Table: Their documents with status "needs_revision" (action required)
- Table: Their 5 most recently reviewed documents
- Quick link button to upload a new document

## Constraints
- All data via eager-loaded Eloquent queries in the controller. No N+1.
- No charts, graphs, or JS libraries.
- Only make changes directly requested.