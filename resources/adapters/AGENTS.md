# Agent Guidance — Laravel Best Practices (Neutral)

This repo contains a portable skill used by multiple coding agents.

Canonical rules and workflow:
- `.codex/skills/laravel-best-practices/SKILL.md`
- `.codex/skills/laravel-best-practices/references/rulebook.json`

If you review code, include:
- rule_id
- evidence (file + lines)
- recommendation
- patch outline
- test plan impact

If you generate code, prefer:
- FormRequest + Service/Action + thin controller
- Policies for authorization (never inline ability checks in services)
- `config('key')` — never `env()` outside config files
- Eloquent + Collections; `sole()`, `firstOrCreate()`, model casts
- Pest tests when available
- Follow Laravel naming conventions (singular controllers, PascalCase models)

For Inertia + React code, apply rules INRT-001–INRT-010:
- Directory layout: `common`, `modules`, `pages`, `shadcn`
- Page components: `Page` suffix, default export, typed props
- One component per `.tsx` file; function declarations; PascalCase
- `usePage<T>()` for shared data; `useForm` for submissions
- `<Link>` for internal navigation; `router.reload({ only: [...] })` for partial refreshes
