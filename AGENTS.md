# AGENTS.md — Project Rules & Development Standards

> **Stack**: Laravel 12 · TailwindCSS 4 · Alpine.js 3  
> **Philosophy**: Senior-level engineering · KISS · Security-first  
> **Last Updated**: August 2026 (rev. 2)

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
- Use **eager loading** (`with()`) to prevent N+1 queries. Enable lazy-loading prevention only outside production: `Model::preventLazyLoading(! app()->isProduction());` in `AppServiceProvider::boot()`.
- Define all **relationships** in models with proper return type hints.
- Use **migrations** for all schema changes. Never modify the database manually.
- Use `$casts` property for attribute casting. Use Laravel's built-in casts before creating custom ones.
- **Encrypt sensitive columns at rest** using the `encrypted` cast (or `encrypted:array`/`encrypted:collection`) for PII, tokens, and secrets stored in the database.
- Use **`$hidden`** on models to keep sensitive attributes (passwords, tokens, secrets) out of serialized output and logs.
- Add **database indexes** on columns used in `WHERE`, `ORDER BY`, and `JOIN` clauses.
- Use **soft deletes** (`SoftDeletes`) for user-facing data that may need recovery.

```php
// ✅ Good — Explicit fillable, casts, relationships
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status', 'user_id', 'starts_at'];

    protected $hidden = ['api_token'];

    protected $casts = [
        'status' => ProjectStatus::class,
        'starts_at' => 'datetime',
        'api_token' => 'encrypted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### 2.3 Routing

- Use **route model binding** for all resource routes.
- **Authorize every bound model, including reads.** Route model binding resolves a record by ID but does NOT check ownership. After binding, call `$this->authorize('view', $project)` (or the relevant ability) on **every** action — show/edit/update/destroy alike. Forgetting this is the most common real-world Laravel vulnerability (IDOR): a logged-in user swapping the ID in the URL to read or modify another user's record.
- Prefer **scoped bindings** for nested resources (`/users/{user}/projects/{project}`) so the child is resolved through the parent relationship, not by global ID.
- Group routes with **middleware** and **prefixes** logically.
- Use **named routes** exclusively. Never hardcode URLs.
- Use **`Route::resource()`** or **`Route::apiResource()`** for standard CRUD.
- Use **rate limiting** on authentication routes and API endpoints.

### 2.4 Blade Templates

- Use **Blade components** (`<x-component>`) over `@include` for reusable UI.
- Use reusable Blade layouts and components. Do not assume `<x-app-layout>` must be used. Create custom layouts/components whenever they better fit the project's design system.
- Always use **`{{ }}`** (escaped output) for user-generated content. Only use `{!! !!}` when you have explicitly sanitized the content.
- Use **`@csrf`** on every form. No exceptions.
- Use **`@method('PUT')`**, `@method('DELETE')` etc. for non-GET/POST forms.
- Use **`@auth`**, **`@guest`**, **`@can`** directives for conditional rendering.
- Keep Blade templates lean — no complex PHP logic. Move logic to View Composers, components, or computed properties.

### 2.5 API Development

- Return consistent JSON responses using **API Resources** (`JsonResource`).
- Use **API versioning** via route prefixes (`/api/v1/`).
- Use **Laravel Sanctum** for API authentication, choosing the mode deliberately: **SPA authentication** is cookie/session based (first-party front-ends on the same domain), while **API token authentication** issues bearer tokens (mobile apps, third-party clients). These are different modes — do not mix them in one flow.
- Always return proper **HTTP status codes** (201 for created, 204 for no content, 422 for validation errors, etc.).
- Paginate all list endpoints using `->paginate()` or `->cursorPaginate()`.

---

## 3. TailwindCSS 4 Standards

### 3.1 General Rules

- Use **TailwindCSS 4** with the new CSS-first configuration approach. Tailwind v4 uses `@import "tailwindcss"` and `@theme` blocks in CSS instead of `tailwind.config.js`.
- **Utilities in markup first.** Reach for Tailwind utility classes before anything else. `@apply` is allowed only inside component CSS where a utility string repeats and becomes unmaintainable. Never write freehand custom CSS unless a genuine utility gap exists — these three rules resolve in that order.
- Use the **design token system** (`@theme`) for project-wide colors, fonts, spacing, and breakpoints.
- Follow **mobile-first** responsive design. Use `sm:`, `md:`, `lg:`, `xl:` prefixes.
- Use **dark mode** with the `dark:` variant. Configure the **selector (class-based) strategy** via `@custom-variant dark (&:where(.dark, .dark *));` so a manual toggle can override the OS setting. Do NOT rely on the media-only default — it makes user-controlled dark mode toggles impossible.

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

Tailwind v4 uses the **Vite plugin** — no `tailwind.config.js` or `postcss.config.js`. Configure in `vite.config.js`:

```js
// vite.config.js
import tailwindcss from '@tailwindcss/vite';
export default defineConfig({
    plugins: [laravel({ ... }), tailwindcss()],
});
```

All design tokens live in `resources/css/app.css`:

```css
/* resources/css/app.css */
@import "tailwindcss";

/* Class-based dark mode */
@custom-variant dark (&:where(.dark, .dark *));

@theme {
    /* ── Primary: teal / hue 185 (project brand) ── */
    --color-primary-50:  oklch(0.97  0.02  185);
    --color-primary-100: oklch(0.93  0.04  185);
    --color-primary-500: oklch(0.55  0.15  185);
    --color-primary-600: oklch(0.48  0.15  185);
    --color-primary-700: oklch(0.40  0.15  185);

    /* ── Surface: cool-slate / hue 220 ── */
    --color-surface-50:  oklch(0.985 0.002 220);
    --color-surface-200: oklch(0.92  0.005 220);
    --color-surface-700: oklch(0.35  0.02  220);
    --color-surface-900: oklch(0.18  0.03  220);

    /* ── Semantic ── */
    --color-danger-500:  oklch(0.55  0.22  25);
    --color-success-500: oklch(0.60  0.17  155);
    --color-warning-500: oklch(0.75  0.18  85);

    /* ── Typography ── */
    --font-sans: "Inter", ui-sans-serif, system-ui, sans-serif;
    --font-mono: "JetBrains Mono", ui-monospace, monospace;

    /* ── Radius ── */
    --radius-DEFAULT: 0.5rem;
    --radius-lg:      0.75rem;
    --radius-xl:      1rem;
    --radius-2xl:     1.5rem;
}
```

### 3.4 Component Layer

Reusable patterns are defined in `@layer components` inside `app.css`, not scattered in templates. Use these classes in Blade — do not re-implement them inline:

| Class | Purpose |
|---|---|
| `.card` | White rounded card with border + shadow |
| `.card-body` | Standard `1.5rem` padding |
| `.form-input` | Styled text input with focus ring |
| `.form-label` | Label with correct weight/spacing |
| `.btn` | Base button (use with modifier) |
| `.btn-primary` | Teal gradient action button |
| `.btn-secondary` | Outlined secondary button |
| `.btn-danger` | Red gradient destructive button |
| `.alert-success / -danger / -info` | Feedback alerts with icon support |
| `.glass` | `backdrop-blur-xl` glassmorphism surface |
| `.animate-fade-in / -slide-up / -scale-in` | Entry animations |

---

## 4. UI/UX Design Standards

### Philosophy

Laravel Breeze is used **only for backend scaffolding** (authentication, routing, validation, sessions, controllers, requests, and models). Never treat Breeze as the project's frontend or design system.

When redesigning:
- Replace the UI instead of incrementally modifying it.
- Do not preserve Breeze HTML, layouts, utility classes, visual hierarchy, or components unless explicitly requested.
- Preserve only routes, Blade directives, CSRF, validation, input names, auth logic, authorization, and session handling.

### Full Redesign Mode

If a request includes words like "redesign", "modernize", "improve UI", "improve UX", "rebuild frontend" or similar:
- Think like a Product Designer first and Laravel developer second.
- Generate a fresh implementation instead of editing the existing frontend.
- Keep backend behaviour intact.

---

### Established Design System

This project has an implemented design system. **Always follow it** when adding new pages or components. Do not invent new patterns that contradict what is already established below.

#### Color Palette
- **Primary**: Teal (oklch hue 185). Use `text-primary-*`, `bg-primary-*`, `border-primary-*`.
- **Surface**: Cool-slate (oklch hue 220). Use `text-surface-*`, `bg-surface-*` for all neutral UI.
- **Danger**: Red (oklch hue 25) — destructive actions only.
- **Success**: Green (oklch hue 155) — positive feedback only.
- **Warning**: Amber (oklch hue 85) — caution states.
- ❌ Do NOT use Tailwind's default `indigo`, `blue`, `gray`, or `zinc` palettes — they conflict with the `surface`/`primary` token system.

#### Typography
- Font: **Inter** loaded from `fonts.bunny.net`. Always use `font-sans`.
- Headings: `font-bold` or `font-semibold`, `tracking-tight`.
- Body: `text-surface-900`, `text-surface-600` for muted/secondary text.
- Labels: always use the `.form-label` class or `<x-input-label>` component.

#### Layout — Authenticated Pages
- **Desktop (`sm:` and above)**: Horizontal top navigation bar (glassmorphism, `glass` utility) — logo left, nav links center, user dropdown right.
- **Mobile**: Fixed **bottom navigation bar** (`<x-bottom-nav>`) with icon tabs (Home, Profile, Logout). No hamburger menus.
- Content area must have `pb-20 sm:pb-0` to avoid overlap with the mobile bottom nav.
- Use `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8` for standard page widths. Use `max-w-3xl` for settings/form pages.

#### Layout — Guest Pages (Auth)
- Use the **split-screen** guest layout: teal gradient branding panel (left half, desktop only) + form panel (right half).
- On mobile, collapses to a single column with a small logo above the form.
- Do NOT create full-screen centered card layouts — use the existing `x-guest-layout`.

#### Glassmorphism
- Use the `.glass` utility for surfaces that float over content: nav bar, bottom nav, dropdowns, modals.
- `.glass` = `backdrop-blur-xl bg-white/80`. Apply `border border-surface-200/60` for definition.

#### Cards
- Use `.card` + `.card-body` for content sections. Never use ad-hoc `bg-white rounded shadow p-6`.
- Stagger entrance animations with `animate-slide-up` and inline `style="animation-delay: Xms"`.

#### Motion
- Entry animations: `animate-fade-in` (opacity only), `animate-slide-up` (opacity + translateY), `animate-scale-in` (opacity + scale).
- All defined in `app.css`. Default duration: 400ms ease-out.
- Transitions on interactive elements: `transition-colors duration-200` or `transition-all duration-200`.
- Button hover: subtle `translateY(-1px)` lift on `.btn-primary` and `.btn-danger`.

#### Icons
- Use **Heroicons** inline SVG (outline style, `stroke-width="1.5"` for decorative, `stroke-width="2"` for small/action icons).
- Size pairing: `w-4 h-4` (inline/button), `w-5 h-5` (card header), `w-6 h-6` (bottom nav tabs).
- Icon-only buttons need `aria-label`.

#### Accessibility
- All form inputs must have a visible `<x-input-label>` (use `class="sr-only"` only for inputs with clear surrounding context).
- Focus rings: `focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-2`.
- Modal must trap focus and close on `Escape` — use the `<x-modal>` component, never roll your own.
- Bottom nav logout is a `<form>` submit — never a bare `<a>` tag.

### Premium UI Principles

Prioritize:
- Clear visual hierarchy
- Generous whitespace
- Consistent spacing
- Accessible color contrast (WCAG AA minimum)
- Responsive layouts (mobile-first)
- Empty, loading, and error states on every list/data view
- Reusable components over copy-pasted HTML
- Subtle, purposeful animations

Avoid:
- Using `gray`, `indigo`, or `zinc` Tailwind colors (breaks token system)
- Sidebar navigation layouts (the project uses horizontal + bottom nav)
- Hamburger menus (mobile uses bottom nav)
- Breeze-style centered white card auth pages
- Hardcoded hex/rgb colors — always use design tokens
- Page-by-page design inconsistencies

---

## 5. Alpine.js 3 Standards

### 5.1 General Rules

- Use **Alpine.js** for client-side interactivity. It replaces the need for Vue or React in Blade-rendered apps.
- Keep Alpine components **small and focused**. If a component exceeds ~30 lines of JS, extract it to an `Alpine.data()` registration.
- Use **`x-data`** for component state, **`x-bind`** for dynamic attributes, **`x-on`** for events, **`x-show`/`x-if`** for conditional rendering.
- Prefer **`x-show`** over **`x-if`** unless you need to completely remove the element from the DOM.
- Use **`x-transition`** for smooth UI transitions.
- Use **`$dispatch`** and **`x-on`** for cross-component communication.
- Use **`Alpine.store()`** for global state that multiple components need.
- **Never put business logic in Alpine.js**. It handles UI state only. Business logic belongs on the server.

### 5.2 Pattern Examples

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

## 6. Security Standards (Non-Negotiable)

### 6.1 Input & Output

- **Validate ALL input** using Form Request classes. Define explicit rules for every field.
- **Never trust client-side validation** alone. Always validate server-side.
- **Escape all output** in Blade using `{{ }}`. Only use `{!! !!}` with `strip_tags()`, `Purifier`, or trusted content.
- **Sanitize file uploads** — validate MIME types, file size, and store outside the public directory. Use `Storage::disk('local')`.
- **Serve private files through a gated route**, never a public URL. Authorize the request, then stream via `Storage::download()`/`response()->file()`, or issue a short-lived `Storage::temporaryUrl()` / signed URL. Storing outside `public/` only works as a control if serving is also gated.
- Use **`$request->validated()`** to only pass validated data to models. Never use `$request->all()`.

### 6.2 Authentication & Authorization

- Use **Laravel Sanctum** for API auth and **Laravel's built-in session auth** for web.
- Implement **Policies** for every model that has user-scoped access.
- Use **Gates** for non-model authorization logic.
- **Rate limit** login attempts using Laravel's built-in throttle middleware.
- Use **`auth()->user()`** to scope all queries to the authenticated user. Never rely on user IDs passed from the client.
- Implement **password confirmation** for sensitive actions (e.g., deleting account, changing email).

### 6.3 Database Security

- **Never use raw SQL with user input**. Always use parameterized queries or Eloquent.
- Use **`$fillable`** on all models. Never use `$guarded = []` in production.
- Scope **all queries** to the authenticated user where applicable. Never trust route parameters alone for authorization — a resolved model must still be authorized on read (see Routing: authorize every bound model).

### 6.4 Session & CSRF

- **`@csrf`** on every form. No exceptions.
- Use **`SameSite=Lax`** or **`SameSite=Strict`** cookies (Laravel default).
- Set **`SESSION_SECURE_COOKIE=true`** in production.
- Regenerate session after login: `$request->session()->regenerate()`.

### 6.5 Environment & Secrets

- **Never commit `.env`** files. Use `.env.example` as a template.
- Use **`config()`** helper to access environment values. Never call `env()` outside of config files.
- Store API keys and secrets in **`.env`** only. Never hardcode secrets.
- Set **`APP_DEBUG=false`** in production.
- Set **`APP_ENV=production`** in production.
- **Keep secrets out of logs.** Never log full request payloads on auth or payment routes, never log credentials or tokens, and rely on model `$hidden` so sensitive attributes never reach serialized log output.

### 6.6 Headers & CORS

- Configure **CORS** properly in `config/cors.php`. Whitelist specific origins, never use `*` in production.
- Use **Content Security Policy (CSP)** headers via middleware.
- Set **`X-Frame-Options: DENY`** to prevent clickjacking.

### 6.7 Dependencies & Supply Chain

- **Prefer Laravel's built-ins over new packages** (this is a security control, not just KISS — every dependency is attack surface).
- Before adding any package, justify it: is it actively maintained, widely used, and not trivially replaceable with framework features?
- **Pin versions** with sensible constraints in `composer.json`/`package.json`; commit lock files.
- Run **`composer audit`** and **`npm audit`** in CI, not just at deploy time.

---

## 7. Code Style & Conventions

### 7.1 PHP

- Follow **PSR-12** coding standard.
- Use **strict types**: `declare(strict_types=1);` at the top of every PHP file.
- Use **PHP 8.2+ features** where they improve clarity: readonly properties, enums, named arguments, match expressions, null-safe operator. Do NOT reach for low-level primitives like fibers in application code — they almost never belong there (KISS).
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

### 7.2 JavaScript (Alpine.js Context)

- Use **modern ES6+** syntax: `const`/`let`, arrow functions, template literals, destructuring.
- Use **`async/await`** over Promises with `.then()`.
- **No jQuery**. Ever. Alpine.js and vanilla JS cover all use cases.

### 7.3 Comments & Documentation

- Write **PHPDoc blocks** for all public methods.
- Write **inline comments** only for "why", not "what". The code should explain "what."
- Document **non-obvious business rules** with comments.
- Keep a **`CHANGELOG.md`** for significant changes.

---

## 8. Testing Standards

### 8.1 Backend Testing

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

### 8.2 Frontend Testing

- Use **Laravel Dusk** for critical user flows (login, checkout, form submissions).
- Keep Dusk tests focused on **integration/E2E behavior**, not unit-level DOM testing.

---

## 9. Performance Guidelines

- Use **Laravel's cache** (`Cache::remember()`) for expensive queries and computations.
- Use **queue jobs** for long-running tasks (emails, PDF generation, API calls).
- Use **lazy collections** (`cursor()`) when processing large datasets.
- Optimize images using **responsive `srcset`** and modern formats (WebP/AVIF).
- Use **Vite** for asset bundling (Laravel 12 default). Do NOT use Mix.
- Enable **OPcache** in production.
- Use **`php artisan optimize`** in production deployments.

---

## 10. Project Structure

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

## 11. Git & Workflow

- Write **conventional commit messages**: `feat:`, `fix:`, `refactor:`, `docs:`, `test:`, `chore:`.
- Keep commits **atomic** — one logical change per commit.
- Use **feature branches** off `main`. Never commit directly to `main`.
- Run **`php artisan test`** and **`./vendor/bin/pint`** before every commit.
- Use **Laravel Pint** for code formatting (Laravel 12 default formatter).

---

## 12. Deployment Checklist

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

## 13. KISS Reminders

> **Before writing any code, ask yourself:**

1. **Does Laravel already have this?** — Check the docs before adding a package or writing custom code.
2. **Can this be simpler?** — If you're writing an abstract factory for two implementations, just use an `if` statement.
3. **Will a junior understand this?** — If not, simplify it.
4. **Am I solving a real problem?** — Don't architect for hypothetical future requirements.
5. **Is this the smallest change that works?** — Make it work, make it right, then (if needed) make it fast.

---

*This document is the single source of truth for development standards in this project. Follow it strictly. When in doubt, choose the simplest, most secure approach.*