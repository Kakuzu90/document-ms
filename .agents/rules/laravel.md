---
trigger: always_on
---

# Laravel 12 Standards

> Load this file for any PHP, controller, model, route, migration, or Blade task.

---

## Architecture & Patterns

- Use **Laravel's default MVC structure**. Do NOT introduce hexagonal architecture, DDD, or repository patterns unless the project explicitly demands it. KISS.
- Use **single-action controllers** (`__invoke`) for simple endpoints. Use resource controllers for CRUD operations.
- Keep controllers thin — delegate business logic to **Action classes** (`app/Actions/`) or **Service classes** (`app/Services/`) only when logic is reused or complex.
- Use **Form Request** classes for all validation. Never validate inline in controllers.
- Use **Policies** for authorization. Never check permissions inline in controllers.
- Use **Enums** (PHP 8.1+ backed enums) instead of magic strings or constants for status values, types, and roles.
- Use **DTOs** sparingly — only when passing structured data between layers. Prefer arrays or value objects for simple cases.

---

## Eloquent & Database

- Always use **Eloquent** unless raw performance requires Query Builder or raw SQL.
- Define **`$fillable`** on every model. Never use `$guarded = []`.
- Always use **database transactions** (`DB::transaction()`) for operations that modify multiple tables.
- Use **eager loading** (`with()`) to prevent N+1 queries. Enable lazy-loading prevention only outside production:
  ```php
  // AppServiceProvider::boot()
  Model::preventLazyLoading(! app()->isProduction());
  ```
- Define all **relationships** in models with proper return type hints.
- Use **migrations** for all schema changes. Never modify the database manually.
- Use `$casts` for attribute casting. Use built-in casts before writing custom ones.
- **Encrypt sensitive columns at rest** using the `encrypted` cast (or `encrypted:array` / `encrypted:collection`) for PII, tokens, and secrets.
- Use **`$hidden`** to keep sensitive attributes (passwords, tokens, secrets) out of serialized output and logs.
- Add **database indexes** on columns used in `WHERE`, `ORDER BY`, and `JOIN` clauses.
- Use **soft deletes** (`SoftDeletes`) for user-facing data that may need recovery.

```php
// ✅ Good — Explicit fillable, hidden, casts, relationships
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status', 'user_id', 'starts_at'];

    protected $hidden = ['api_token'];

    protected $casts = [
        'status'    => ProjectStatus::class,
        'starts_at' => 'datetime',
        'api_token' => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

---

## Routing

- Use **route model binding** for all resource routes.
- **Authorize every bound model — including reads.** Route model binding resolves by ID but does NOT check ownership. Call `$this->authorize('view', $project)` on every action: show, edit, update, destroy. Forgetting this is the most common real-world Laravel vulnerability (IDOR). See `security.md → IDOR`.
- Prefer **scoped bindings** for nested resources (`/users/{user}/projects/{project}`) so the child resolves through the parent, not by global ID.
- Group routes with **middleware** and **prefixes** logically.
- Use **named routes** exclusively. Never hardcode URLs.
- Use **`Route::resource()`** or **`Route::apiResource()`** for standard CRUD.
- Use **rate limiting** on authentication routes and API endpoints.

---

## Blade Templates

- Use **Blade components** (`<x-component>`) over `@include` for reusable UI.
- Do not assume `<x-app-layout>` must be used. Create custom layouts/components whenever they better fit the project's design system.
- Always use **`{{ }}`** (escaped output) for user-generated content. Only use `{!! !!}` when content has been explicitly sanitized.
- Use **`@csrf`** on every form. No exceptions.
- Use **`@method('PUT')`**, `@method('DELETE')` etc. for non-GET/POST forms.
- Use **`@auth`**, **`@guest`**, **`@can`** directives for conditional rendering.
- Keep Blade templates lean — no complex PHP logic. Move logic to View Composers, components, or computed properties.

---

## API Development

- Return consistent JSON responses using **API Resources** (`JsonResource`).
- Use **API versioning** via route prefixes (`/api/v1/`).
- Use **Laravel Sanctum** for API authentication. Choose the mode deliberately:
  - **SPA authentication** — cookie/session based, for first-party front-ends on the same domain.
  - **API token authentication** — bearer tokens, for mobile apps or third-party clients.
  - Do not mix these modes in a single flow.
- Always return proper **HTTP status codes** (201 created, 204 no content, 422 validation error, etc.).
- Paginate all list endpoints using `->paginate()` or `->cursorPaginate()`.

---

## Project Structure

```
app/
├── Actions/           # Single-purpose action classes
├── Enums/             # PHP backed enums
├── Http/
│   ├── Controllers/   # Thin controllers
│   ├── Middleware/    # Custom middleware
│   └── Requests/      # Form Request validation
├── Models/            # Eloquent models
├── Notifications/     # Notification classes
├── Policies/          # Authorization policies
├── Providers/         # Service providers
└── Services/          # Complex business logic (use sparingly)

resources/
├── css/
│   └── app.css        # TailwindCSS 4 with @theme config
├── js/
│   ├── app.js         # Alpine.js init + global components
│   └── components/    # Extracted Alpine.js components
└── views/
    ├── components/    # Blade components
    ├── layouts/       # Layout templates
    └── pages/         # Page-specific views (grouped by feature)

tests/
├── Feature/           # HTTP/integration tests (Pest)
└── Unit/              # Unit tests (Pest)
```