# GitHub Copilot Instructions — Laravel Best Practices

Follow repository Laravel conventions and apply the rules in:
- `.codex/skills/laravel-best-practices/SKILL.md`
- `.codex/skills/laravel-best-practices/references/rulebook.json`

Key rules:
- Use FormRequests for validation/authorization (VAL-001).
- Keep controllers thin; move business logic to Services/Actions (MVC-001, SVC-001).
- Use Policies for authorization; never inline ability checks in services (AUTH-001).
- Never call `env()` outside config files; use `config('key')` everywhere (CONF-001).
- Avoid DB queries in Blade; eager load to prevent N+1 (BLADE-001).
- Prefer Eloquent + Collections; use `sole()`, `firstOrCreate()`, model casts (ELO-001).
- Chunk/stream large dataset operations (PERF-001).
- Follow Laravel naming conventions: singular controllers, PascalCase models (NAMING-001).

Inertia + React rules:
- Follow `common` / `modules` / `pages` / `shadcn` directory layout (INRT-001).
- Suffix page components with `Page` and use a default export (INRT-002).
- One component per `.tsx`, function declarations, PascalCase (INRT-003).
- Wrap shadcn components instead of importing them directly app-wide (INRT-004).
- No barrel files; use absolute aliased imports (INRT-005).
- Type all page props with a TypeScript interface; use `usePage<T>()` for shared data (INRT-006).
- Use `useForm` from `@inertiajs/react` — not axios/fetch — for form submissions (INRT-007).
- Read auth/flash/global data via `usePage()` instead of prop-drilling (INRT-008).
- Use `<Link>` for internal navigation; never plain `<a>` tags (INRT-009).
- Use `router.reload({ only: [...] })` for partial prop refreshes (INRT-010).

When proposing refactors, reference the corresponding rule id (e.g., VAL-001, SVC-001, INRT-006).
