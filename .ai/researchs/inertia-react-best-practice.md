# Research: Inertia + React Best Practices Implementation

## Current State

The project already has 5 React-specific rules (`INRT-001` – `INRT-005`) in `rulebook.json`, covering:

| ID | Title |
|----|-------|
| INRT-001 | Directory conventions (`common`, `modules`, `pages`, `shadcn`) |
| INRT-002 | Page components: suffix `Page`, default export |
| INRT-003 | One component per file, PascalCase, function declarations |
| INRT-004 | Wrap shadcn components; don't import them directly app-wide |
| INRT-005 | No barrel files; use absolute aliased imports; consistent casing |

**What's missing compared to Vue:** The Vue side has a companion reference doc (`references/inertia-vue.md`) with a full annotated directory tree, key conventions summary, a minimal component example, and migration notes. React has no equivalent file.

---

## What Needs to Be Implemented

### 1. Create `references/inertia-react.md`

Mirror the structure of `inertia-vue.md` but for React/TSX. Must include:

**a) Annotated directory tree**

```
resources
├── css
│   └── app.css
└── js
    ├── common
    │   ├── button
    │   │   └── Button.tsx
    │   └── card
    │       ├── Card.tsx
    │       ├── CardHeader.tsx
    │       └── CardContent.tsx
    ├── modules
    │   ├── auth
    │   │   ├── useCurrentUser.ts
    │   │   └── Avatar.tsx
    │   └── categories
    │       └── CategoryBadge.tsx
    ├── pages
    │   ├── layouts
    │   │   └── Layout.tsx
    │   ├── profile
    │   │   ├── layouts
    │   │   │   └── ProfileLayout.tsx
    │   │   └── ProfilePage.tsx
    │   └── posts
    │       ├── components
    │       │   └── PublishStatus.tsx
    │       ├── helpers
    │       │   └── generateSlug.ts
    │       ├── CreatePostPage.tsx
    │       ├── EditPostPage.tsx
    │       └── PostsIndexPage.tsx
    ├── shadcn
    │   └── (generated shadcn-ui components)
    └── app.tsx
```

**b) Key conventions summary** (parallel to Vue doc):
- Directories: `kebab-case`
- Component files: `PascalCase`, one component per `.tsx` file
- Helpers/hooks: `camelCase` `.ts` files (e.g. `useCurrentUser.ts`)
- Pages: suffix with `Page`, default export (e.g. `PostsIndexPage.tsx`)
- Prefer function declarations over const arrow components
- Group hooks under `common/hooks` or `modules/<feature>/hooks`
- Avoid barrel/index files; import directly using `@/` alias
- Keep shadcn components under `resources/js/shadcn`; wrap in `common` for project API

**c) Minimal component example** (TypeScript function declaration):

```tsx
interface ButtonProps {
  type?: 'button' | 'submit';
  className?: string;
  children: React.ReactNode;
}

export function Button({ type = 'button', className, children }: ButtonProps) {
  return (
    <button type={type} className={className}>
      {children}
    </button>
  );
}
```

**d) References** to `INRT-001`..`INRT-005` in `rulebook.json`.

---

### 2. Add Missing Rules to `rulebook.json`

The Vue side and React side are currently symmetric at 5 rules each, but the React rules lack coverage for some React-specific concerns. Propose these additions:

#### INRT-006 — TypeScript: type Inertia page props at the component boundary

- **Severity:** high
- **Signals:**
  - Page component accepts untyped `props` or uses `any`
  - Props passed from controller accessed via `usePage().props` without a typed interface
- **Recommended pattern:**
  - Define an interface for page props and destructure from the component parameter
  - Use `usePage<PageProps>()` when accessing shared data
- **Example bad:** `export default function PostsIndexPage(props: any) { ... }`
- **Example good:** `export default function PostsIndexPage({ posts }: PostsIndexPageProps) { ... }`

#### INRT-007 — Use `useForm` for Inertia form submissions; avoid raw `fetch`/`axios`

- **Severity:** high
- **Signals:**
  - Form submissions using `axios.post` or `fetch` instead of Inertia's `useForm` or `router`
  - Manual loading/error state management when Inertia already tracks it
- **Recommended pattern:**
  - Use `useForm({ ... })` for forms; access `.processing`, `.errors`, `.reset()`
  - Use `router.visit`, `router.post`, etc. for programmatic navigation
- **Example bad:** `axios.post('/posts', data).then(...).catch(...)`
- **Example good:** `const { data, post, processing, errors } = useForm({ title: '' })`

#### INRT-008 — Use `usePage` for shared/global data; avoid prop drilling

- **Severity:** medium
- **Signals:**
  - Auth user, flash messages, or other shared data passed as explicit props through many component layers
  - Re-fetching data that is already available via Inertia shared data
- **Recommended pattern:**
  - Share global data via `HandleInertiaRequests::share()` on the server side
  - Access it in components with `usePage<SharedProps>().props.auth.user`
- **Example bad:** `<Layout user={props.user}><PostsList user={props.user} /></Layout>`
- **Example good:** `const { auth } = usePage<SharedProps>().props`

---

### 3. Update `resources/skills/laravel-best-practices/SKILL.md`

Add a "Frontend / Inertia" section (or expand the existing core principles) to mention:
- When reviewing Inertia React pages: apply `INRT-001`..`INRT-008`
- Point to `references/inertia-react.md` for the directory conventions reference

---

### 4. Update Adapter Files

**`resources/adapters/CLAUDE.md`:** Add a mention of Inertia React rules (`INRT-001`–`INRT-008`) alongside existing backend rules.

**`resources/adapters/copilot-instructions.md`:** Add key Inertia React pointers (typed props, `useForm`, `usePage`) in the same bullet style as existing backend rules.

**`resources/adapters/AGENTS.md`:** Same additions.

---

### 5. Add Tests

**`tests/Unit/InertiaRulesTest.php`** — extend to assert new rules `INRT-006`, `INRT-007`, `INRT-008` exist in the rulebook (follow the same pattern already used for `INRT-001`..`INRT-005`).

No new feature (publish) tests are needed since `inertia-react.md` is added to the existing skill directory — the existing publish tests already cover that the whole `laravel-best-practices` directory is published correctly.

---

## Implementation Checklist

- [ ] Create `resources/skills/laravel-best-practices/references/inertia-react.md`
- [ ] Add `INRT-006`, `INRT-007`, `INRT-008` to `rulebook.json`
- [ ] Update `SKILL.md` to reference Inertia React rules and the new doc
- [ ] Update `resources/adapters/CLAUDE.md` with Inertia React pointers
- [ ] Update `resources/adapters/copilot-instructions.md` with Inertia React pointers
- [ ] Update `resources/adapters/AGENTS.md` with Inertia React pointers
- [ ] Extend `tests/Unit/InertiaRulesTest.php` to cover new rule IDs
- [ ] Bump version in `composer.json`

---

## File Inventory

| File | Action |
|------|--------|
| `resources/skills/.../references/inertia-react.md` | **Create** |
| `resources/skills/.../references/rulebook.json` | **Modify** — add INRT-006, INRT-007, INRT-008 |
| `resources/skills/.../SKILL.md` | **Modify** — add Inertia frontend section |
| `resources/adapters/CLAUDE.md` | **Modify** — add Inertia React rules reference |
| `resources/adapters/copilot-instructions.md` | **Modify** — add Inertia React key rules |
| `resources/adapters/AGENTS.md` | **Modify** — add Inertia React key rules |
| `tests/Unit/InertiaRulesTest.php` | **Modify** — assert INRT-006, INRT-007, INRT-008 |
| `composer.json` | **Modify** — bump version |
