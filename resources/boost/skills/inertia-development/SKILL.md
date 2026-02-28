---
name: inertia-development
description: Conventions and best practices for Inertia.js apps with React or Vue — directory structure, page components, forms, shared data, navigation, and partial reloads.
---

# Inertia Development

## When to use this skill
Use when implementing or reviewing Inertia.js pages, components, forms, or navigation in a Laravel app (React or Vue).

---

## Directory structure

```
resources/js/
  common/    # shared UI primitives
  modules/   # feature/domain code
  pages/     # Inertia-rendered pages (mirrors URL structure)
  shadcn/    # generated shadcn-ui (React) — do not edit directly
  lib/       # third-party UI library components (Vue)
  app.tsx / app.ts
```

---

## React conventions

**Page components** — suffix `Page`, default export, typed props:
```tsx
interface PostsIndexPageProps { posts: Post[] }
export default function PostsIndexPage({ posts }: PostsIndexPageProps) { ... }
```

**Components** — one per `.tsx` file, function declaration, PascalCase filename:
```tsx
export function Button({ children }: ButtonProps) { ... }  // Button.tsx
```

**Forms** — use `useForm`, never raw `axios`/`fetch`:
```tsx
const { data, setData, post, processing, errors } = useForm({ title: '' });
```

**Shared data** — use `usePage<SharedProps>().props`, not prop drilling:
```tsx
const { auth } = usePage<SharedProps>().props;
```

**Navigation** — use `<Link>`, not `<a>`:
```tsx
<Link href="/posts">View Posts</Link>
```

---

## Vue conventions

**Page components** — suffix `Page`, default export via `<script setup>`:
```vue
<!-- PostsIndexPage.vue -->
<script setup lang="ts">
defineProps<{ posts: Post[] }>();
</script>
```

**Components** — one per `.vue` file, PascalCase filename, prefer `<script setup>` + Composition API.

**Third-party UI** — keep under `lib/`, wrap in `common/` with a project-friendly API.

---

## Shared conventions (React + Vue)

- **Directories**: kebab-case. **Component files**: PascalCase. **Helpers/hooks/composables**: camelCase `.ts`.
- Avoid barrel/index files — import directly: `@/common/button/Button`.
- Wrap shadcn/third-party components; never import them directly across the app.
- **Partial reloads**: `router.reload({ only: ['propName'] })` instead of full visits to refresh one prop.
- **Deferred props**: mark expensive data with `Inertia::defer()` on the server to load after first render.

---

## Rules reference
See `rulebook.json` entries `INRT-001`–`INRT-010` (React) and `INRT-VUE-001`–`INRT-VUE-005` (Vue).