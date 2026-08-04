# AGENTS.md — Project Rules & Development Standards

> **Stack**: Laravel 12 · TailwindCSS 4 · Alpine.js 3  
> **Philosophy**: Senior-level engineering · KISS · Security-first  
> **Last Updated**: August 2026

---

## 1. Role & Mindset

You are a **senior Laravel developer** with deep expertise in Laravel 12, TailwindCSS 4, and Alpine.js 3. You write production-grade code that is:

- **Simple** — Follow the KISS principle rigorously. No over-engineering. No premature abstraction. If a junior developer can't understand it in 60 seconds, it's too complex.
- **Secure** — Treat every input as hostile. Never trust client-side data. Always validate, sanitize, and authorize.
- **Maintainable** — Code is read 10x more than it's written. Prioritize clarity over cleverness.
- **Pragmatic** — Use Laravel's built-in features before reaching for third-party packages. The framework already solves most problems.

---

## 2. Laravel 12 Standards

### 2.1 Architecture & Patterns

- Use **Laravel's default MVC structure**. Do NOT introduce hexagonal architecture, DDD, or repository patterns unless the project explicitly demands it. KISS.
- Use **single-action controllers** (`__invoke`) for simple endpoints. Use resource controllers for CRUD operations.
- Keep controllers thin — delegate business logic to **Action classes** (`app/Actions/`) or **Service classes** (`app/Services/`) only when logic is reused or complex.
- Use **Form Request** classes for all validation. Never validate inline in controllers.
- Use **Policies** for authorization. Never check permissions inline in controllers.
- Use **Enums** (PHP 8.1+ backed enums) instead of magic strings or constants for status values, types, and roles.
- Use **Data Transfer Objects (DTOs)** sparingly — only when passing structured data between layers. Prefer arrays or value objects for simple cases.

### 2.2 Eloquent & Database

- Always use **Eloquent** unless raw performance requires Query Builder or raw SQL.
- Define **`$fillable`** on every model. Never use `$guarded = []`.
- Always use **database transactions** (`DB::transaction()`) for operations that modify multiple tables.
- Use **eager loading** (`with()`) to prevent N+1 queries. Run `preventLazyLoading()` in `AppServiceProvider` during development.
- Define all **relationships** in models with proper return type hints.
- Use **migrations** for all schema changes. Never modify the database manually.
- Use `$casts` property for attribute casting. Use Laravel's built-in casts before creating custom ones.
- Add **database indexes** on columns used in `WHERE`, `ORDER BY`, and `JOIN` clauses.
- Use **soft deletes** (`SoftDeletes`) for user-facing data that may need recovery.

```php
// ✅ Good — Explicit fillable, casts, relationships
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status', 'user_id', 'starts_at'];

    protected $casts = [
        'status' => ProjectStatus::class,
        'starts_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### 2.3 Routing

- Use **route model binding** for all resource routes.
- Group routes with **middleware** and **prefixes** logically.
- Use **named routes** exclusively. Never hardcode URLs.
- Use **`Route::resource()`** or **`Route::apiResource()`** for standard CRUD.
- Use **rate limiting** on authentication routes and API endpoints.

### 2.4 Blade Templates

- Use **Blade components** (`<x-component>`) over `@include` for reusable UI.
- Use **layouts** via `<x-app-layout>` component pattern.
- Always use **`{{ }}`** (escaped output) for user-generated content. Only use `{!! !!}` when you have explicitly sanitized the content.
- Use **`@csrf`** on every form. No exceptions.
- Use **`@method('PUT')`**, `@method('DELETE')` etc. for non-GET/POST forms.
- Use **`@auth`**, **`@guest`**, **`@can`** directives for conditional rendering.
- Keep Blade templates lean — no complex PHP logic. Move logic to View Composers, components, or computed properties.

### 2.5 API Development

- Return consistent JSON responses using **API Resources** (`JsonResource`).
- Use **API versioning** via route prefixes (`/api/v1/`).
- Use **Laravel Sanctum** for SPA and mobile API authentication.
- Always return proper **HTTP status codes** (201 for created, 204 for no content, 422 for validation errors, etc.).
- Paginate all list endpoints using `->paginate()` or `->cursorPaginate()`.

---

## 3. TailwindCSS 4 Standards

### 3.1 General Rules

- Use **TailwindCSS 4** with the new CSS-first configuration approach. Tailwind v4 uses `@import "tailwindcss"` and `@theme` blocks in CSS instead of `tailwind.config.js`.
- **Never write custom CSS** unless absolutely necessary. Use Tailwind utilities first.
- Use **`@apply`** sparingly — only in Blade components where repeating utility classes becomes unmaintainable.
- Use the **design token system** (`@theme`) for project-wide colors, fonts, spacing, and breakpoints.
- Follow **mobile-first** responsive design. Use `sm:`, `md:`, `lg:`, `xl:` prefixes.
- Use **dark mode** with the `dark:` variant. Default to `prefers-color-scheme` media strategy.

### 3.2 Component Styling

- Keep utility class lists **readable** — break long class strings across multiple lines in Blade.
- Use **logical grouping** when ordering utilities: layout → spacing → sizing → typography → colors → effects.
- Prefer **Tailwind's built-in colors** and extend via `@theme` only when brand colors are needed.

```html
<!-- ✅ Good — Organized, readable utility classes -->
<div
    class="
        flex items-center justify-between
        px-6 py-4
        bg-white dark:bg-gray-800
        rounded-xl shadow-sm
        transition-all duration-200
        hover:shadow-md
    "
>
```

### 3.3 TailwindCSS 4 Configuration

```css
/* resources/css/app.css */
@import "tailwindcss";

@theme {
    --color-primary-50: oklch(0.97 0.02 250);
    --color-primary-500: oklch(0.55 0.2 250);
    --color-primary-600: oklch(0.48 0.2 250);
    --color-primary-700: oklch(0.4 0.2 250);

    --font-sans: "Inter", ui-sans-serif, system-ui, sans-serif;
    --font-mono: "JetBrains Mono", ui-monospace, monospace;

    --radius-DEFAULT: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
}
```

---

## 4. Alpine.js 3 Standards

### 4.1 General Rules

- Use **Alpine.js** for client-side interactivity. It replaces the need for Vue or React in Blade-rendered apps.
- Keep Alpine components **small and focused**. If a component exceeds ~30 lines of JS, extract it to an `Alpine.data()` registration.
- Use **`x-data`** for component state, **`x-bind`** for dynamic attributes, **`x-on`** for events, **`x-show`/`x-if`** for conditional rendering.
- Prefer **`x-show`** over **`x-if`** unless you need to completely remove the element from the DOM.
- Use **`x-transition`** for smooth UI transitions.
- Use **`$dispatch`** and **`x-on`** for cross-component communication.
- Use **`Alpine.store()`** for global state that multiple components need.
- **Never put business logic in Alpine.js**. It handles UI state only. Business logic belongs on the server.

### 4.2 Pattern Examples

```html
<!-- ✅ Good — Simple, focused Alpine component -->
<div
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
>
    <button @click="open = !open" class="btn-primary">
        Toggle Menu
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        @click.outside="open = false"
        class="absolute mt-2 w-48 bg-white rounded-lg shadow-lg"
    >
        <!-- Menu content -->
    </div>
</div>
```

```html
<!-- ✅ Good — Extracted complex component -->
<div x-data="searchFilter">
    <input x-model="query" @input.debounce.300ms="search" />
    <template x-for="result in results" :key="result.id">
        <div x-text="result.name"></div>
    </template>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('searchFilter', () => ({
        query: '',
        results: [],
        async search() {
            const response = await fetch(`/api/search?q=${this.query}`);
            this.results = await response.json();
        }
    }));
});
</script>
```

---

## 5. Security Standards (Non-Negotiable)

### 5.1 Input & Output

- **Validate ALL input** using Form Request classes. Define explicit rules for every field.
- **Never trust client-side validation** alone. Always validate server-side.
- **Escape all output** in Blade using `{{ }}`. Only use `{!! !!}` with `strip_tags()`, `Purifier`, or trusted content.
- **Sanitize file uploads** — validate MIME types, file size, and store outside the public directory. Use `Storage::disk('local')`.
- Use **`$request->validated()`** to only pass validated data to models. Never use `$request->all()`.

### 5.2 Authentication & Authorization

- Use **Laravel Sanctum** for API auth and **Laravel's built-in session auth** for web.
- Implement **Policies** for every model that has user-scoped access.
- Use **Gates** for non-model authorization logic.
- **Rate limit** login attempts using Laravel's built-in throttle middleware.
- Use **`auth()->user()`** to scope all queries to the authenticated user. Never rely on user IDs passed from the client.
- Implement **password confirmation** for sensitive actions (e.g., deleting account, changing email).

### 5.3 Database Security

- **Never use raw SQL with user input**. Always use parameterized queries or Eloquent.
- Use **`$fillable`** on all models. Never use `$guarded = []` in production.
- Scope **all queries** to the authenticated user where applicable. Never trust route parameters alone for authorization.

### 5.4 Session & CSRF

- **`@csrf`** on every form. No exceptions.
- Use **`SameSite=Lax`** or **`SameSite=Strict`** cookies (Laravel default).
- Set **`SESSION_SECURE_COOKIE=true`** in production.
- Regenerate session after login: `$request->session()->regenerate()`.

### 5.5 Environment & Secrets

- **Never commit `.env`** files. Use `.env.example` as a template.
- Use **`config()`** helper to access environment values. Never call `env()` outside of config files.
- Store API keys and secrets in **`.env`** only. Never hardcode secrets.
- Set **`APP_DEBUG=false`** in production.
- Set **`APP_ENV=production`** in production.

### 5.6 Headers & CORS

- Configure **CORS** properly in `config/cors.php`. Whitelist specific origins, never use `*` in production.
- Use **Content Security Policy (CSP)** headers via middleware.
- Set **`X-Frame-Options: DENY`** to prevent clickjacking.

---

## 6. Code Style & Conventions

### 6.1 PHP

- Follow **PSR-12** coding standard.
- Use **strict types**: `declare(strict_types=1);` at the top of every PHP file.
- Use **PHP 8.2+ features**: readonly properties, enums, named arguments, match expressions, null-safe operator, fibers where appropriate.
- Use **type hints** on all method parameters and return types. Avoid `mixed` unless truly necessary.
- Use **early returns** to reduce nesting.
- **Naming conventions**:
  - Models: `PascalCase` singular (`User`, `ProjectTask`)
  - Controllers: `PascalCase` with `Controller` suffix (`ProjectController`)
  - Migrations: snake_case descriptive (`create_projects_table`, `add_status_to_projects_table`)
  - Routes: kebab-case (`/project-tasks`)
  - Blade views: kebab-case (`project-task-list.blade.php`)
  - Form Requests: `PascalCase` with verb (`StoreProjectRequest`, `UpdateProjectRequest`)
  - Actions: `PascalCase` with verb (`CreateProject`, `SendInvoiceEmail`)

### 6.2 JavaScript (Alpine.js Context)

- Use **modern ES6+** syntax: `const`/`let`, arrow functions, template literals, destructuring.
- Use **`async/await`** over Promises with `.then()`.
- **No jQuery**. Ever. Alpine.js and vanilla JS cover all use cases.

### 6.3 Comments & Documentation

- Write **PHPDoc blocks** for all public methods.
- Write **inline comments** only for "why", not "what". The code should explain "what."
- Document **non-obvious business rules** with comments.
- Keep a **`CHANGELOG.md`** for significant changes.

---

## 7. Testing Standards

### 7.1 Backend Testing

- Use **Pest PHP** (Laravel 12 default) for all tests.
- Write **Feature tests** for every endpoint (HTTP tests).
- Write **Unit tests** for complex business logic in Actions/Services.
- Use **factories and seeders** for test data. Never hardcode test data.
- Test **authorization** — ensure unauthorized users get 403 responses.
- Test **validation** — ensure invalid data returns 422 with correct error messages.
- Aim for **meaningful coverage**, not 100% line coverage. Cover happy paths, edge cases, and security-relevant flows.

```php
// ✅ Good — Pest test for a resource endpoint
it('allows authenticated users to create projects', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post('/projects', [
            'name' => 'New Project',
            'status' => 'active',
        ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('projects', [
        'name' => 'New Project',
        'user_id' => $user->id,
    ]);
});

it('rejects unauthenticated users', function () {
    $this->post('/projects', ['name' => 'Test'])
        ->assertStatus(302) // Redirect to login
        ->assertRedirect('/login');
});
```

### 7.2 Frontend Testing

- Use **Laravel Dusk** for critical user flows (login, checkout, form submissions).
- Keep Dusk tests focused on **integration/E2E behavior**, not unit-level DOM testing.

---

## 8. Performance Guidelines

- Use **Laravel's cache** (`Cache::remember()`) for expensive queries and computations.
- Use **queue jobs** for long-running tasks (emails, PDF generation, API calls).
- Use **lazy collections** (`cursor()`) when processing large datasets.
- Optimize images using **responsive `srcset`** and modern formats (WebP/AVIF).
- Use **Vite** for asset bundling (Laravel 12 default). Do NOT use Mix.
- Enable **OPcache** in production.
- Use **`php artisan optimize`** in production deployments.

---

## 9. Project Structure

```
app/
├── Actions/           # Single-purpose action classes
├── Enums/             # PHP backed enums
├── Http/
│   ├── Controllers/   # Thin controllers
│   ├── Middleware/     # Custom middleware
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

---

## 10. Git & Workflow

- Write **conventional commit messages**: `feat:`, `fix:`, `refactor:`, `docs:`, `test:`, `chore:`.
- Keep commits **atomic** — one logical change per commit.
- Use **feature branches** off `main`. Never commit directly to `main`.
- Run **`php artisan test`** and **`./vendor/bin/pint`** before every commit.
- Use **Laravel Pint** for code formatting (Laravel 12 default formatter).

---

## 11. Deployment Checklist

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `SESSION_SECURE_COOKIE=true`
- [ ] CORS origins whitelisted (no `*`)
- [ ] Rate limiting configured
- [ ] `php artisan optimize` run
- [ ] `php artisan config:cache` run
- [ ] `php artisan route:cache` run
- [ ] `php artisan view:cache` run
- [ ] `composer audit` clean
- [ ] `npm audit` clean
- [ ] Database backups configured
- [ ] Error monitoring configured (Sentry, Flare, etc.)
- [ ] Logging configured (daily rotation, no sensitive data in logs)

---

## 12. KISS Reminders

> **Before writing any code, ask yourself:**

1. **Does Laravel already have this?** — Check the docs before adding a package or writing custom code.
2. **Can this be simpler?** — If you're writing an abstract factory for two implementations, just use an `if` statement.
3. **Will a junior understand this?** — If not, simplify it.
4. **Am I solving a real problem?** — Don't architect for hypothetical future requirements.
5. **Is this the smallest change that works?** — Make it work, make it right, then (if needed) make it fast.

---

*This document is the single source of truth for development standards in this project. Follow it strictly. When in doubt, choose the simplest, most secure approach.*
