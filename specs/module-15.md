## Objective
Add reply functionality to the comments section so admins and teachers can reply to individual
comments, with the parent comment visually highlighted when composing or viewing a reply.

## Context
Module 4 is complete. `comments` table: id, document_id, user_id, body, created_at.
Admin can post comments; teachers read them. No replies exist yet.

## Target State
Migration:
- Add nullable `parent_id` (FK → comments.id, set null on delete) to the comments table
- Add nullable `quoted_text` (text, nullable) — stores a short excerpt of the parent body
  displayed as a quote block in the reply, so context is clear without nesting deeply

Comment display (both admin and teacher views):
- Top-level comments render as before
- Replies render indented beneath their parent (left border: border-l-2 border-[color]-300 pl-4)
- Each reply shows a quote block above the reply body:
    Quoted style: text-xs text-[color]-400 italic bg-[color]-50 rounded p-2 mb-2
    Content: first 120 characters of the parent body, truncated with "…" if longer
    Label: "Replying to [Parent Author Name]:" above the quote
- "Reply" link on each top-level comment (and on replies): plain text, [color], small
  Clicking "Reply" navigates to the comment form pre-filled via query param:`
    ?reply_to={comment_id}  — page scrolls to the form (use #comment-form anchor)
  No inline form injection, no AJAX — plain GET link + anchor

Comment form (admin detail view):
- When ?reply_to={comment_id} is present in the URL:
    - Show a "Replying to [Author]:" quote block above the textarea, styled as above
      (fetch the parent comment in the controller and pass it to the view)
    - Add a hidden input: name="parent_id" value="{comment_id}"
    - Add a hidden input: name="quoted_text" value="{first 120 chars of parent body}"
    - Add a "Cancel reply" link that strips the query param (links to the same URL without it)
    - Highlight the parent comment row: add ring-2 ring-[color]-400 to its container via Blade
      @if(request('reply_to') == $comment->id)
  Normal form (no query param): no hidden inputs, no quote block — unchanged

CommentController@store update:
- Accept parent_id (nullable, must exist in comments, same document_id) and quoted_text
  (nullable, max:150) in addition to existing body validation
- Save both to the DB if present

Teacher detail view:
- Teacher can see replies indented under parent comments (read-only, no reply form for teachers)

## Constraints
- No JavaScript beyond native browser anchor scroll (#comment-form).
- No recursive nesting — replies are always one level deep. A reply to a reply still shows
  under the original top-level comment (parent_id always points to a root comment).
- quoted_text is captured at reply time and stored — do not re-query the parent body on render.
- Only make changes directly requested. Do not add comment editing, deletion, or reactions.