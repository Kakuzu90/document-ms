---
trigger: always_on
---

# Workflow Standards — Code Style · Testing · Performance · Git · Deployment

> Load this file for code style questions, testing tasks, git workflow, or pre-deploy checks.

---

## PHP Code Style

- Follow **PSR-12** coding standard. Use **Laravel Pint** for formatting (`./vendor/bin/pint`).
- Use **strict types**: `declare(strict_types=1);` at the top of every PHP file.
- Use **PHP 8.2+ features** where they improve clarity: readonly properties, enums, named arguments, match expressions, null-safe operator. Do NOT reach for low-level primitives like fibers in application code — they almost never belong there (KISS).
- Use **type hints** on all method parameters and return types. Avoid `mixed` unless truly necessary.
- Use **early returns** to reduce nesting.

**Naming conventions:**

| Thing | Convention | Example |
|---|---|---|
| Models | `PascalCase` singular | `User`, `ProjectTask` |
| Controllers | `PascalCase` + `Controller` | `ProjectController` |
| Migrations | `snake_case` descriptive | `create_projects_table` |
| Routes | kebab-case | `/project-tasks` |
| Blade views | kebab-case | `project-task-list.blade.php` |
| Form Requests | verb + noun | `StoreProjectRequest` |
| Actions | verb + noun | `CreateProject`, `SendInvoiceEmail` |

---

## JavaScript Style

- Use **modern ES6+**: `const`/`let`, arrow functions, template literals, destructuring.
- Use **`async/await`** over `.then()` chains.
- **No jQuery.** Ever. Alpine.js and vanilla JS cover all use cases.

---

## Comments & Documentation

- Write **PHPDoc blocks** for all public methods.
- Write inline comments only for **"why"**, not "what" — the code explains what.
- Document **non-obvious business rules** with comments.
- Keep a **`CHANGELOG.md`** for significant changes.

---

## Testing

- Use **Pest PHP** (Laravel 12 default) for all tests.
- Write **Feature tests** for every endpoint (HTTP tests).
- Write **Unit tests** for complex business logic in Actions/Services.
- Use **factories and seeders** for test data. Never hardcode test data.
- Test **authorization** — ensure unauthorized users receive 403 responses.
- Test **validation** — ensure invalid data returns 422 with correct error messages.
- Aim for **meaningful coverage**, not 100% line coverage. Cover happy paths, edge cases, and security-relevant flows.
- Use **Laravel Dusk** for critical E2E flows (login, checkout, form submissions). Keep Dusk tests behavioral, not DOM-unit-level.

```php
// ✅ Pest feature test pattern
it('allows authenticated users to create projects', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post('/projects', ['name' => 'New Project', 'status' => 'active'])
        ->assertStatus(201);

    $this->assertDatabaseHas('projects', [
        'name'    => 'New Project',
        'user_id' => $user->id,
    ]);
});

it('rejects unauthenticated users', function () {
    $this->post('/projects', ['name' => 'Test'])
        ->assertStatus(302)
        ->assertRedirect('/login');
});

it('returns 403 when accessing another user\'s project', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $project = Project::factory()->for($owner)->create();

    $this->actingAs($other)
        ->get("/projects/{$project->id}")
        ->assertStatus(403);
});
```

---

## Performance

- Use **`Cache::remember()`** for expensive queries and computations.
- Use **queue jobs** for long-running tasks (emails, PDF generation, external API calls).
- Use **lazy collections** (`cursor()`) when processing large datasets.
- Optimize images: **responsive `srcset`**, WebP/AVIF formats.
- Use **Vite** for asset bundling (Laravel 12 default). Do NOT use Mix.
- Enable **OPcache** in production.
- Run **`php artisan optimize`** on every production deployment.

---

## Git & Workflow

- Write **conventional commit messages**: `feat:`, `fix:`, `refactor:`, `docs:`, `test:`, `chore:`.
- Keep commits **atomic** — one logical change per commit.
- Use **feature branches** off `main`. Never commit directly to `main`.
- Run **`php artisan test`** and **`./vendor/bin/pint`** before every commit.

---

## Deployment Checklist

Run this before every production deployment:

**Environment**
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] `SESSION_SECURE_COOKIE=true`
- [ ] CORS origins whitelisted (no `*`)
- [ ] Rate limiting configured on auth + API routes

**Cache & Optimization**
- [ ] `php artisan optimize`
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`

**Security Audit**
- [ ] `composer audit` — clean
- [ ] `npm audit` — clean

**Infrastructure**
- [ ] Database backups configured and tested
- [ ] Error monitoring configured (Sentry, Flare, etc.)
- [ ] Logging: daily rotation enabled, no sensitive data in logs

---

## KISS Reminders

Before writing any code, ask:

1. **Does Laravel already have this?** Check the docs before writing custom code or adding a package.
2. **Can this be simpler?** If you're writing an abstract factory for two implementations, use an `if` statement.
3. **Will a junior understand this?** If not, simplify it.
4. **Am I solving a real problem?** Don't architect for hypothetical future requirements.
5. **Is this the smallest change that works?** Make it work → make it right → (only if needed) make it fast.