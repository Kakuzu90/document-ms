---
trigger: always_on
---

# Laravel 12 Standards

> Load this file for any PHP, controller, model, route, migration, or Blade task.

---

## Architecture & Patterns

### ⚡ Before writing any controller method — run this checklist

A controller method has exactly one job: **authorize → validate → call action/service → return response.** Nothing else belongs in it.

Before writing any logic inside a controller, answer these questions:

1. **Does this involve more than a single query or model operation?** → Extract to `app/Actions/` (single-use) or `app/Services/` (reused across multiple callers).
2. **Is this logic used by more than one controller, job, or command?** → Extract to `app/Services/`.
3. **Is this a single CRUD operation on one model?** → An Action class is still preferred, but inline is acceptable if it stays under ~5 lines.
4. **Am I about to write business logic directly in the controller?** → Stop. Move it first, then call it.

If extraction is needed, **create the file first**, then call it from the controller. Never leave business logic inline with a "refactor later" intention.

```php
// ✅ Correct — controller delegates everything
class ProjectController extends Controller
{
    public function store(StoreProjectRequest $request, CreateProject $action): JsonResponse
    {
        $this->authorize('create', Project::class);

        $project = $action->handle($request->validated(), auth()->user());

        return response()->json($project, 201);
    }
}

// ❌ Wrong — business logic leaking into controller
class ProjectController extends Controller
{
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $this->authorize('create', Project::class);

        $project = Project::create([...$request->validated(), 'user_id' => auth()->id()]);
        $project->members()->attach(auth()->id(), ['role' => 'owner']);
        Mail::to(auth()->user())->send(new ProjectCreated($project));

        return response()->json($project, 201);
    }
}
```

### General Rules

- Use **Laravel's default MVC structure**. Do NOT introduce hexagonal architecture, DDD, or repository patterns unless the project explicitly demands it. KISS.
- Use **single-action controllers** (`__invoke`) for simple endpoints. Use resource controllers for CRUD operations.
- Keep controllers thin — the pre-check above enforces this on every method.
- Use **Form Request** classes for all validation. Never validate inline in controllers.
- Use **Policies** for authorization. Never check permissions inline in controllers.
- Use **Enums** (PHP 8.1+ backed enums) instead of magic strings or constants for status values, types, and roles.
- Use **DTOs** sparingly — only when passing structured data between layers. Prefer arrays or value objects for simple cases.

---

## Eloquent & Database

### Repositories — Don't

- **Do NOT create repository classes.** Eloquent is the data layer. Only propose a repository if the same data must come from two different backends (e.g. DB plus an external API), and state that reason out loud before writing it.
- Query logic belongs in **local scopes** (`scopeActive`, `scopeForUser`) and **relationships** on the model. Reach for a standalone query object only when a query exceeds ~15 lines.

### Eager Loading — Where It Lives

- **Eager-load in the controller or scope, never in the Blade view.** `Model::preventLazyLoading(! app()->isProduction())` is on — an N+1 is a bug, not a performance note.
- Load with context: pass a fully loaded model/collection into the view; the view renders, it does not query.

```php
// ✅ Correct — eager-load in the controller
public function index(): View
{
    $projects = auth()->user()
        ->projects()
        ->with(['members', 'tasks' => fn ($q) => $q->incomplete()])
        ->latest()
        ->paginate(20);

    return view('projects.index', compact('projects'));
}

// ❌ Wrong — lazy-loading triggered inside the view
// resources/views/projects/index.blade.php
@foreach ($projects as $project)
    {{ $project->members->count() }}  {{-- query per row --}}
@endforeach
```

### Casts — Cast Everything Non-String

- **Cast every non-string column** in `$casts`. Dates, booleans, decimals, enums, JSON — if it isn't a plain string, it must be cast. Never let raw integers or "0"/"1" leak into application code.
- Use **PHP backed enums** for status columns. Never bare strings.
- **Encrypt sensitive columns at rest** using the `encrypted` cast (or `encrypted:array` / `encrypted:collection`) for PII, tokens, and secrets.
- Use **`$hidden`** to keep sensitive attributes (passwords, tokens, secrets) out of serialized output and logs.

### Raw SQL — Bindings Only

- **Never write raw SQL with string interpolation.** Use Eloquent or the query builder. If raw SQL is truly unavoidable, always use bindings:
  ```php
  // ✅ Correct
  ->whereRaw('LOWER(name) = ?', [strtolower($value)])

  // ❌ Wrong — SQL injection vector
  ->whereRaw("LOWER(name) = '{$value}'")
  ```

### General Model Rules

- Define **`$fillable`** on every model. Never use `$guarded = []`.
- Always use **database transactions** (`DB::transaction()`) for operations that modify multiple tables.
- Define all **relationships** in models with proper return type hints.
- Use **migrations** for all schema changes. Never modify the database manually.
- Add **database indexes** on columns used in `WHERE`, `ORDER BY`, and `JOIN` clauses.
- Use **soft deletes** (`SoftDeletes`) for user-facing data that may need recovery.

```php
// ✅ Good — scopes, casts, relationships, hidden, fillable all in one place
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status', 'user_id', 'starts_at'];

    protected $hidden = ['api_token'];

    protected $casts = [
        'status'     => ProjectStatus::class,  // enum — never bare string
        'starts_at'  => 'datetime',
        'is_public'  => 'boolean',
        'budget'     => 'decimal:2',
        'meta'       => 'array',
        'api_token'  => 'encrypted',
    ];

    // Query logic lives here, not in controllers or services
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', ProjectStatus::Active);
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where('user_id', $user->id);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
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
├── Actions/           # CREATE when a controller method does more than authorize+validate+return.
│                      # One class = one operation. e.g. CreateProject, ArchiveInvoice.
│                      # Single-use: if only one caller exists, prefer Action over Service.
├── Enums/             # PHP backed enums — replace all magic strings/constants
├── Http/
│   ├── Controllers/   # Thin. authorize → validate → call Action/Service → return. Nothing else.
│   ├── Middleware/    # Custom middleware only
│   └── Requests/      # One FormRequest per controller action (Store, Update, etc.)
├── Models/            # Eloquent models — relationships, casts, scopes only
├── Notifications/     # Laravel Notification classes
├── Policies/          # One Policy per model — all authorization logic lives here
├── Providers/         # Service providers
└── Services/          # CREATE when logic is reused by multiple controllers, jobs, or commands.
                       # If only one controller calls it, use an Action instead.

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