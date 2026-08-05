---
trigger: always_on
---

# Security Standards (Non-Negotiable)

> These rules apply to **every task**. There are no exceptions based on task size or urgency.

---

## IDOR — Authorize Every Bound Model

**This is the most common real-world Laravel vulnerability.**

Route model binding resolves a record by the ID in the URL — it does NOT check ownership. A logged-in user can swap the ID and read or modify another user's record unless you explicitly authorize.

**Rule**: Call `$this->authorize()` on every controller action, including reads:

```php
public function show(Project $project): View
{
    $this->authorize('view', $project); // ← required on show/read too
    return view('projects.show', compact('project'));
}
```

Also prefer **scoped bindings** for nested resources so the child is resolved through the parent relationship, not by global ID:

```php
// routes/web.php
Route::resource('users.projects', ProjectController::class)->scoped();
```

---

## Input & Output

- **Validate ALL input** using Form Request classes. Define explicit rules for every field.
- **Never trust client-side validation** alone. Always validate server-side.
- **Escape all output** in Blade using `{{ }}`. Only use `{!! !!}` with `strip_tags()`, `Purifier`, or verified-safe content.
- **Use `$request->validated()`** to pass data to models. Never use `$request->all()`.

---

## File Uploads

- Validate **MIME types and file size** on every upload. Never trust the client-supplied MIME.
- **Store outside the public directory**. Use `Storage::disk('local')`.
- **Serve private files through a gated route** — never a direct public URL. Authorize the request, then either:
  - Stream: `Storage::download()` / `response()->file()`
  - Issue a short-lived signed URL: `Storage::temporaryUrl()`
- Storing outside `public/` is only a security control if serving is also gated.

---

## Authentication & Authorization

- Use **Laravel Sanctum** for API auth and **Laravel's built-in session auth** for web.
- Implement **Policies** for every model that has user-scoped access.
- Use **Gates** for non-model authorization logic.
- **Rate limit** login attempts using Laravel's built-in throttle middleware.
- Use **`auth()->user()`** to scope all queries to the authenticated user. Never rely on IDs passed from the client.
- Implement **password confirmation** for sensitive actions (deleting account, changing email).

---

## Database Security

- **Never use raw SQL with user input.** Always use parameterized queries or Eloquent.
- Define **`$fillable`** on all models. Never use `$guarded = []` in production.
- Scope **all queries** to the authenticated user. A resolved model must still be authorized on read — never trust route parameters alone (see IDOR above).

---

## Session & CSRF

- **`@csrf`** on every form. No exceptions.
- Use **`SameSite=Lax`** or **`SameSite=Strict`** cookies (Laravel default).
- Set **`SESSION_SECURE_COOKIE=true`** in production.
- Regenerate session after login: `$request->session()->regenerate()`.

---

## Environment & Secrets

- **Never commit `.env`** files. Use `.env.example` as a template.
- Use **`config()`** to access environment values. Never call `env()` outside of config files.
- Store API keys and secrets in **`.env`** only. Never hardcode secrets.
- Set **`APP_DEBUG=false`** and **`APP_ENV=production`** in production.
- **Keep secrets out of logs.** Never log full request payloads on auth or payment routes. Rely on model `$hidden` so sensitive attributes never reach serialized log output.

---

## Headers & CORS

- Configure **CORS** in `config/cors.php`. Whitelist specific origins — never use `*` in production.
- Use **Content Security Policy (CSP)** headers via middleware.
- Set **`X-Frame-Options: DENY`** to prevent clickjacking.

---

## Dependencies & Supply Chain

Every dependency is attack surface. Treat package addition as a security decision, not just a convenience one.

- **Prefer Laravel's built-ins** over new packages.
- Before adding any package: is it actively maintained? Widely used? Not trivially replaceable with framework features?
- **Pin versions** with sensible constraints in `composer.json` / `package.json`. Commit lock files.
- Run **`composer audit`** and **`npm audit`** in CI — not just at deploy time.