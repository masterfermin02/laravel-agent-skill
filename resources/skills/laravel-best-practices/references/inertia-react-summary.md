Inertia + React — Quick Reference

## Directory layout

```
resources/js/
  common/      shared UI primitives (Button.tsx, Card.tsx, hooks/)
  modules/     feature/domain code (auth/, posts/, categories/)
  pages/       Inertia-rendered pages mirroring URL structure
  shadcn/      generated shadcn-ui — do not edit directly
  app.tsx
```

## File & naming rules

| Thing | Convention | Example |
|-------|-----------|---------|
| Directory | kebab-case | `user-profile/` |
| Component file | PascalCase | `Button.tsx` |
| Hook / helper | camelCase | `useCurrentUser.ts` |
| Page component | PascalCase + `Page` suffix | `PostsIndexPage.tsx` |

## Component rules (INRT-003)

```tsx
// one component per file, function declaration, named export
export function Button({ children }: ButtonProps) {
  return <button>{children}</button>;
}
```

## Page component rules (INRT-002, INRT-006)

```tsx
interface PostsIndexPageProps { posts: Post[] }

export default function PostsIndexPage({ posts }: PostsIndexPageProps) {
  // typed props + default export
}
```

## Forms (INRT-007)

```tsx
// never: axios.post('/posts', data)
const { data, setData, post, processing, errors } = useForm({ title: '' });
function submit(e: React.FormEvent) { e.preventDefault(); post('/posts'); }
```

## Shared / global data (INRT-008)

```tsx
// never prop-drill auth, flash, etc.
const { auth } = usePage<SharedProps>().props;
```

## Navigation (INRT-009)

```tsx
// never: <a href="/posts">
<Link href="/posts">View Posts</Link>

// programmatic
router.visit('/posts');
```

## Partial reloads (INRT-010)

```tsx
// never: router.visit('/dashboard') just to refresh one prop
router.reload({ only: ['notifications'] });
```

## Import style (INRT-005)

```tsx
// never: import { Button } from '@/common'
import { Button } from '@/common/button/Button';
```

## shadcn wrappers (INRT-004)

```
shadcn/select.tsx          ← generated, do not modify
common/fruit-select/FruitSelect.tsx  ← thin wrapper with project API
```

## Full rules reference
See `rulebook.json` entries `INRT-001`..`INRT-010`.
