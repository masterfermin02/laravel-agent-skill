---
name: php-update-with-rector
description: >
  Upgrades a PHP project to a newer PHP version using Rector — the automated refactoring tool.
  Inspects composer.json, detects the current PHP version, selects safe PHP-level rulesets,
  updates dependencies conservatively, runs a dry-run first, and produces an upgrade checklist
  with follow-up manual changes. Activate for phrases like "upgrade my PHP version",
  "modernize PHP syntax", "migrate to PHP 8.3", "fix PHP 8 deprecations",
  "set up Rector for PHP upgrade", or any request to automate PHP syntax modernization —
  even when Rector is not mentioned by name.
license: MIT
compatible_agents:
  - claude-code
  - cursor
  - windsurf
tags:
  - php
  - rector
  - upgrade
  - migration
metadata:
  author: fperdomo
  version: "1.0.0"
  installed_path: .codex/skills/php-update-with-rector
---

# PHP Version Upgrade with Rector

You are helping upgrade a PHP project to a newer PHP version using Rector.

## Core Goals

1. Detect the current PHP version and project type from the codebase
2. Choose a safe upgrade strategy (step by step for large jumps)
3. Configure Rector with the right PHP level sets and paths
4. Execute safely: dry-run first, then apply
5. Deliver a complete upgrade checklist including manual follow-up items

---

## Step 1: Inspect the Project

Read these files before proposing anything:

- `composer.json` — PHP constraint, dependencies, autoload paths
- `composer.lock` — actual installed versions
- `rector.php` or `rector.php.dist` — existing Rector config if present
- `phpunit.xml*` — test framework presence
- `phpstan.neon*` — static analysis tooling
- `.php-cs-fixer.php` or `pint.json` — formatter config

Determine:
- Current PHP constraint (e.g., `"php": ">=8.1"`)
- Project type: generic PHP, library/package, or CLI tool
- Whether Rector is already installed
- Presence of tests and static analysis

---

## Step 2: Decide Target Version

- If the user specified a target, use it
- If not, suggest the latest stable PHP version
- For large jumps (e.g., 7.4 → 8.3), recommend going one major at a time: 7.4 → 8.0, then 8.0 → 8.1, etc.
- Always note that Rector covers syntax changes but not behavioral differences (e.g., stricter type coercion in PHP 8)

---

## Step 3: Composer Dependency Plan

Propose a conservative update:

```bash
composer require rector/rector --dev
```

Also update the PHP constraint in `composer.json`:

```json
"require": {
    "php": ">=8.3"
}
```

Then check for dependency compatibility:

```bash
composer why-not php 8.3
```

Do not aggressively rewrite unrelated packages. Note dependencies that often need attention during PHP upgrades:
- PHPUnit / Pest (major versions tied to PHP versions)
- PHPStan / Larastan
- Symfony components (if used)

---

## Step 4: Configure `rector.php`

Generate bootstrap if none exists:

```bash
vendor/bin/rector init
```

### Minimal PHP upgrade config

```php
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSkip([
        __DIR__ . '/vendor',
    ])
    ->withSets([
        LevelSetList::UP_TO_PHP_83, // adjust to target
    ]);
```

### Available PHP level sets (cumulative — each includes all prior)

| Constant | Target |
|---|---|
| `LevelSetList::UP_TO_PHP_74` | PHP 7.4 |
| `LevelSetList::UP_TO_PHP_80` | PHP 8.0 |
| `LevelSetList::UP_TO_PHP_81` | PHP 8.1 |
| `LevelSetList::UP_TO_PHP_82` | PHP 8.2 |
| `LevelSetList::UP_TO_PHP_83` | PHP 8.3 |

### Optional sets (add incrementally — do not enable all at once on legacy code)

```php
use Rector\Set\ValueObject\SetList;

->withSets([
    LevelSetList::UP_TO_PHP_83,
    SetList::CODE_QUALITY,      // modernizes patterns
    SetList::DEAD_CODE,         // removes unused code
    SetList::TYPE_DECLARATION,  // adds type hints (most invasive)
])
```

### Explicit PHP target (avoids local PHP binary mismatch)

```php
->withPhpSets(php83: true)
```

### Skipping paths or rules

```php
->withSkip([
    __DIR__ . '/src/Legacy',
    \Rector\Php74\Rector\Property\TypedPropertyRector::class,
    \Rector\Php74\Rector\Property\TypedPropertyRector::class => [
        __DIR__ . '/src/SpecificFile.php',
    ],
])
```

---

## Step 5: Safe Execution Sequence

Always suggest this order:

```bash
# 1. Install Rector
composer require rector/rector --dev

# 2. Dry-run — preview only, no writes
vendor/bin/rector process --dry-run

# 3. Review the diff, adjust rector.php if needed, repeat dry-run

# 4. Apply changes
vendor/bin/rector process

# 5. Format (if pint or php-cs-fixer configured)
vendor/bin/pint

# 6. Static analysis
vendor/bin/phpstan analyse

# 7. Run tests
composer test
```

For large codebases:
```bash
vendor/bin/rector process --parallel
php -d memory_limit=-1 vendor/bin/rector process  # if memory errors
```

Commit after each logical batch:
```bash
git add -A && git commit -m "chore: apply Rector PHP 8.3 upgrade rules"
```

---

## Step 6: Deliverables

Always provide:

1. **Composer change proposal** — updated PHP constraint + dev deps
2. **`rector.php` config** — ready to use
3. **Exact commands** — copy-paste ready
4. **Upgrade checklist** — what Rector handles automatically vs. what needs manual review
5. **Risks / manual review points** — behavioral differences in the target PHP version that Rector can't fix

### Things Rector does NOT handle (include in checklist)

- PHP 8.0: `match` expressions, named arguments, nullsafe operator (Rector adds them, but logic changes need review)
- PHP 8.0: removed functions (`each()`, `create_function()`, etc.) — Rector flags but can't always fix safely
- PHP 8.1: `readonly` properties require intentional adoption, not automatic
- PHP 8.2: deprecated dynamic properties — flagged but needs case-by-case review
- Type coercion strictness changes between versions
- `strict_types=1` — Rector may add it; review each file where it does

---

## Common Errors

| Error | Fix |
|---|---|
| `Allowed memory size exhausted` | `php -d memory_limit=-1 vendor/bin/rector process` |
| Rector changes nothing | Check `withPaths()` includes actual source dirs |
| `Class not found` in rector.php | Run `composer dump-autoload` |
| Rector too slow | Add `--parallel` flag |
| Wrong PHP version targeted | Use `->withPhpSets(php83: true)` explicitly |
| Tests fail after Rector | Identify rule with `git bisect` or `git diff`; add to `withSkip()` |