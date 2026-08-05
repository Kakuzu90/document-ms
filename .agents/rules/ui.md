---
trigger: always_on
---

# UI Standards — TailwindCSS 4 · Alpine.js 3 · Design System

> Load this file for any Blade template, Tailwind class, or Alpine.js component.

---

## TailwindCSS 4 — General Rules

- Use **TailwindCSS 4** with the CSS-first approach. Configuration lives in `resources/css/app.css` via `@import "tailwindcss"` and `@theme` blocks. There is no `tailwind.config.js`.
- **Utilities in markup first.** Reach for Tailwind utility classes before anything else.
- **`@apply`** is allowed only inside component CSS where a class string repeats and becomes unmaintainable.
- **Never write freehand custom CSS** unless a genuine utility gap exists. Order of preference: utility classes → `@apply` in component layer → custom CSS.
- Use the **design token system** (`@theme`) for all colors, fonts, spacing, and breakpoints.
- Follow **mobile-first** responsive design. Use `sm:`, `md:`, `lg:`, `xl:` prefixes.
- Use **dark mode** with the `dark:` variant. The project uses the **class-based selector strategy** — `@custom-variant dark (&:where(.dark, .dark *))` — so a manual toggle can override the OS setting. Do NOT rely on the media-only default.

---

## Vite Configuration

Tailwind v4 uses the **Vite plugin** — no `postcss.config.js`:

```js
// vite.config.js
import tailwindcss from '@tailwindcss/vite';
export default defineConfig({
    plugins: [laravel({ ... }), tailwindcss()],
});
```

---

## CSS Configuration (`resources/css/app.css`)

```css
@import "tailwindcss";

/* Class-based dark mode */
@custom-variant dark (&:where(.dark, .dark *));

@theme {
    /* ── Primary: teal / hue 185 ── */
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

---

## Established Design System

**This design system is already implemented. Follow it — do not invent new patterns.**

### Color Palette

| Token | Color | Usage |
|---|---|---|
| `primary-*` | Teal (oklch hue 185) | CTAs, links, focus rings, active states |
| `surface-*` | Cool-slate (oklch hue 220) | All neutral UI, backgrounds, borders |
| `danger-*` | Red (oklch hue 25) | Destructive actions only |
| `success-*` | Green (oklch hue 155) | Positive feedback only |
| `warning-*` | Amber (oklch hue 85) | Caution states |

❌ **Do NOT use** Tailwind's default `gray`, `indigo`, `blue`, or `zinc` palettes — they conflict with the `surface`/`primary` token system.
❌ **Never use hardcoded hex/rgb colors** — always use design tokens.

### Typography

- Font: **Inter** (loaded from `fonts.bunny.net`). Always use `font-sans`.
- Headings: `font-bold` or `font-semibold`, `tracking-tight`.
- Body: `text-surface-900`. Muted/secondary: `text-surface-600`.
- Labels: always use `.form-label` class or `<x-input-label>` component.

### Component Classes

Use these classes — do not re-implement them inline:

| Class | Purpose |
|---|---|
| `.card` | White rounded card with border + shadow |
| `.card-body` | Standard `1.5rem` padding |
| `.form-input` | Styled text input with focus ring |
| `.form-label` | Label with correct weight/spacing |
| `.btn` | Base button (always pair with a modifier) |
| `.btn-primary` | Teal gradient action button |
| `.btn-secondary` | Outlined secondary button |
| `.btn-danger` | Red gradient destructive button |
| `.alert-success` / `.alert-danger` / `.alert-info` | Feedback alerts with icon support |
| `.glass` | `backdrop-blur-xl bg-white/80` glassmorphism surface |
| `.animate-fade-in` | Entry animation — opacity only |
| `.animate-slide-up` | Entry animation — opacity + translateY |
| `.animate-scale-in` | Entry animation — opacity + scale |

### Layout — Authenticated Pages

- **Desktop (`sm:` and above)**: Horizontal top nav bar (`.glass` utility) — logo left, nav links center, user dropdown right.
- **Mobile**: Fixed **bottom navigation bar** (`<x-bottom-nav>`) with icon tabs. No hamburger menus. No sidebar layouts.
- Content area: add `pb-20 sm:pb-0` to avoid overlap with the mobile bottom nav.
- Page width: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`. Use `max-w-3xl` for settings/form pages.

### Layout — Guest Pages (Auth)

- Use the **split-screen** guest layout: teal gradient branding panel (left half, desktop only) + form panel (right half).
- On mobile, collapses to a single column with a small logo above the form.
- Do NOT create full-screen centered card auth pages — use the existing `<x-guest-layout>`.

### Motion

- Entry animations: `animate-fade-in`, `animate-slide-up`, `animate-scale-in`. Default duration: 400ms ease-out.
- Stagger cards with inline `style="animation-delay: Xms"`.
- Interactive elements: `transition-colors duration-200` or `transition-all duration-200`.
- Button hover: subtle `translateY(-1px)` lift on `.btn-primary` and `.btn-danger`.

### Icons

- **Heroicons** inline SVG, outline style.
- `stroke-width="1.5"` for decorative icons, `stroke-width="2"` for small/action icons.
- Sizes: `w-4 h-4` (inline/button), `w-5 h-5` (card header), `w-6 h-6` (bottom nav tabs).
- Icon-only buttons require `aria-label`.

### Glassmorphism

- Use `.glass` for surfaces that float over content: nav bar, bottom nav, dropdowns, modals.
- Add `border border-surface-200/60` for definition.

### Cards

- Always use `.card` + `.card-body`. Never ad-hoc `bg-white rounded shadow p-6`.

---

## Class Ordering

Order utilities within a class string: **layout → spacing → sizing → typography → colors → effects**

```html
<!-- ✅ Good -->
<div
    class="
        flex items-center justify-between
        px-6 py-4
        bg-white dark:bg-surface-900
        rounded-xl shadow-sm
        transition-all duration-200
        hover:shadow-md
    "
>
```

---

## Accessibility

- All form inputs must have a visible `<x-input-label>`. Use `class="sr-only"` only when context makes the label redundant.
- Focus rings: `focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500 focus-visible:ring-offset-2`.
- Modals must trap focus and close on `Escape` — use `<x-modal>`, never a custom implementation.
- Bottom nav logout is a `<form>` submit — never a bare `<a>` tag.
- Color contrast: WCAG AA minimum on all text/background combinations.

---

## UI/UX Design Mode

### Breeze Scaffolding Rule

Laravel Breeze is used **only for backend scaffolding** (auth controllers, routes, requests, models). Never treat Breeze as the project's frontend or design system.

When redesigning, preserve only: routes, Blade directives, CSRF, validation, input names, auth logic, authorization, session handling.
Replace everything else — do not patch Breeze HTML.

### Full Redesign Mode

If a request includes "redesign", "modernize", "improve UI/UX", or "rebuild frontend":
- Think like a **Product Designer first**, Laravel developer second.
- Generate a fresh implementation, not an edit of the existing frontend.
- Keep backend behavior intact.

---

## Alpine.js 3 Standards

- Use **Alpine.js** for client-side interactivity. No Vue, no React, no jQuery.
- Keep Alpine components **small and focused**. Extract to `Alpine.data()` if a component exceeds ~30 lines.
- **Never put business logic in Alpine.js.** It handles UI state only. Business logic belongs on the server.
- Prefer **`x-show`** over `x-if` unless you need to fully remove the element from the DOM.
- Use **`x-transition`** for all show/hide animations.
- Use **`$dispatch`** and **`x-on`** for cross-component communication.
- Use **`Alpine.store()`** for global state shared across multiple components.

```html
<!-- ✅ Simple toggle — inline x-data is fine -->
<div x-data="{ open: false }" @keydown.escape.window="open = false">
    <button @click="open = !open" class="btn-secondary">Toggle</button>
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
        <!-- content -->
    </div>
</div>

<!-- ✅ Complex component — extract to Alpine.data() -->
<div x-data="searchFilter">
    <input x-model="query" @input.debounce.300ms="search" class="form-input" />
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
            const response = await fetch(`/api/search?q=${encodeURIComponent(this.query)}`);
            this.results = await response.json();
        },
    }));
});
</script>
```