# GitHub Copilot Instructions — Laravel Best Practices

Follow repository Laravel conventions and apply the rules in:
- `.codex/skills/laravel-best-practices/SKILL.md`
- `.codex/skills/laravel-best-practices/references/rulebook.json`

Key rules:
- Use FormRequests for validation/authorization.
- Keep controllers thin; move business logic to Services/Actions.
- Avoid DB queries in Blade; eager load to prevent N+1.
- Prefer Eloquent relationships/scopes; avoid raw SQL unless necessary.
- Chunk/stream large dataset operations.

When proposing refactors, reference the corresponding rule id (e.g., VAL-001, SVC-001).
