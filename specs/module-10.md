## Objective
Admin document detail view — back-link:
- [x] When arriving from /admin/teachers/{user} the back-link should read "← Back to [Teacher Name]"
  and point to /admin/teachers/{user}
- [x] When arriving from /admin/documents the back-link should read "← Back to Documents"
  and point to /admin/documents
- [x] Implement using a query param: ?from=teacher&teacher={user_id}
  Blade reads this param to render the correct back-link text and href
- [x] Do not use session flash or referer headers for this

## Constraints
- [x] Back-link logic must be pure Blade: read request()->query('from') and request()->query('teacher').
- [x] If neither param is present, default to "← Back to Documents" linking to /admin/documents.
- [x] Only make changes directly requested. Do not reorder or restyle existing sections of the detail view.
