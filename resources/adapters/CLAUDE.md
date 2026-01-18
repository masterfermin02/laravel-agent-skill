# Claude Code Instructions — Laravel Best Practices

When working in this repository:

- Apply the skill rules in `.codex/skills/laravel-best-practices/SKILL.md`.
- Use rule ids from `.codex/skills/laravel-best-practices/references/rulebook.json` when reviewing.
- Prefer:
    - FormRequest validation + authorization
    - Thin controllers (orchestrate only)
    - Service/Action classes for workflows
    - Eloquent scopes for reusable query logic
    - No DB queries in Blade; eager load relationships
    - chunk()/cursor()/lazy() for large datasets

## Review output
When asked to review code, provide:
- A short summary
- Findings with: rule_id, evidence (file/lines), recommendation, patch outline, and test impact
