---
name: laravel-best-practices
description: Enforce Laravel best practices for code generation and review — SRP, skinny controllers, FormRequests, Policies, service/action classes, Eloquent, Blade safety, and Inertia conventions.
---

# Laravel Best Practices

## When to use this skill
Implementing or refactoring controllers, FormRequests, service/action classes, jobs, policies, or observers; reviewing code or diffs; designing application layering or tests.

---

## Key backend rules

| ID | Rule | Severity |
|----|------|----------|
| SRP-001 | One reason to change per class; extract FormRequest + Service/Action | high |
| MVC-001 | Controllers orchestrate only; move queries to scopes, logic to services | high |
| VAL-001 | Validation in FormRequest (`rules()` + `authorize()`); use `->validated()` | **critical** |
| SVC-001 | Business logic in a service/action with a single `handle()` method | high |
| AUTH-001 | Authorization in Policies; `$this->authorize()` in controllers only | high |
| CONF-001 | Never call `env()` outside config files; use `config('key')` everywhere | high |
| BLADE-001 | No DB queries in Blade; eager load with `with()`/`load()` to avoid N+1 | **critical** |
| PERF-001 | Use `chunk()`/`cursor()`/`lazy()` for large datasets; offload to queued jobs | medium |
| ELO-001 | Prefer Eloquent + Collections; use `sole()`, `firstOrCreate()`, model casts | low |
| NAMING-001 | Follow Laravel naming conventions (singular controllers, PascalCase models) | medium |

## Key Inertia rules

See the `inertia-development` skill for full React + Vue conventions.

| ID | Rule |
|----|------|
| INRT-002 | Page components: `Page` suffix, default export |
| INRT-006 | Type page props with TypeScript interfaces; `usePage<T>()` for shared data |
| INRT-007 | `useForm` for submissions — never raw axios/fetch |
| INRT-008 | `usePage()` for auth/flash — no prop drilling |
| INRT-009 | `<Link>` for internal navigation — no `<a>` |

---

## Review output format

For each finding: `rule_id`, evidence (file + lines), recommendation, patch outline, test impact.

## Test generation

Prefer Pest. Cover: FormRequest rules + authorize(), Service/Action business rules (unit, mocked deps), Feature tests (happy path + validation + authz failure).