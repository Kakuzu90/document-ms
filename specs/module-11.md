## Objective
When a document's status is `reviewed`, disable all interactive elements on the admin document detail
view except the status update panel, so admins cannot add further comments to a
finalised document.

## Context
Module 10 is complete. Admin document detail view at /admin/documents/{document} contains:
  1. Document metadata
  2. Status update panel (PATCH /admin/documents/{document}/status) — Module 10
  3. Status history panel — Module 10
  4. Annotations panel with add-annotation form — Module 6
  5. File replacement upload — Module 6
  6. Comments panel with add-comment form — Module 4

## Target State
When $document->status === 'reviewed':

  Annotation form (section 4):
  - All inputs and the submit button gain the HTML `disabled` attribute
  - A muted notice appears above the form: "This document has been reviewed."

  File replacement upload (section 5):
  - The file input and submit button gain the HTML `disabled` attribute
  - Same muted notice: "This document has been reviewed."

  Comment form (section 6):
  - The textarea and submit button gain the HTML `disabled` attribute
  - Muted notice: "This document has been reviewed."

  Status update panel (section 2) — NOT locked:
  - Remains fully interactive regardless of current status
  - This is the only way to move the document out of `reviewed` back to another status

When $document->status is anything other than 'reviewed':
  - All forms behave exactly as before — no change


## Constraints
- Use pure Blade conditionals: @if($document->status === 'reviewed') ... @endif
- No JavaScript, no Alpine, no CSS classes that hide elements — use HTML disabled attribute and
  visible notice text only
- disabled inputs must retain their current Tailwind classes; add only `disabled:opacity-50
  disabled:cursor-not-allowed` utility classes alongside existing ones — do not restyle
- Only make changes directly requested. Do not add lock behaviour for any other status.