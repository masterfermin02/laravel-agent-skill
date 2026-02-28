# Claude Code Instructions — Laravel Best Practices

When working in this repository:

- Apply the skill rules in `.codex/skills/laravel-best-practices/SKILL.md`.
- Use rule ids from `.codex/skills/laravel-best-practices/references/rulebook.json` when reviewing.
- Prefer:
    - FormRequest validation + authorization
    - Thin controllers (orchestrate only)
    - Service/Action classes for workflows
    - Policies for authorization (`$this->authorize()` in controllers only)
    - `config('key')` everywhere — never `env()` outside config files
    - Eloquent scopes, `sole()`, `firstOrCreate()`, model casts
    - No DB queries in Blade; eager load relationships
    - chunk()/cursor()/lazy() for large datasets
    - Follow Laravel naming conventions (singular controllers, PascalCase models)

## Inertia + React
When reviewing or generating Inertia React frontend code, apply rules `INRT-001`–`INRT-008`:
- Follow `common` / `modules` / `pages` / `shadcn` directory conventions (INRT-001)
- Page components: `Page` suffix, default export (INRT-002)
- One component per `.tsx` file, function declarations, PascalCase (INRT-003)
- Wrap shadcn components; do not import them directly app-wide (INRT-004)
- No barrel files; use absolute aliased imports (INRT-005)
- Type page props with a TypeScript interface; use `usePage<T>()` for shared data (INRT-006)
- Use `useForm` from `@inertiajs/react` for form submissions (INRT-007)
- Access shared/global data via `usePage()` — avoid prop drilling (INRT-008)
- Use `<Link>` for internal navigation; never plain `<a>` (INRT-009)
- Use `router.reload({ only: [...] })` for partial refreshes (INRT-010)

## Review output
When asked to review code, provide:
- A short summary
- Findings with: rule_id, evidence (file/lines), recommendation, patch outline, and test impact
