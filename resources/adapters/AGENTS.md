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
- Eloquent scopes/relationships
- Pest tests when available
