# Block Spec: [Block Name]

> Copy this file to `docs/specs/[block-name].md` before starting work.
> Fill every section. No spec = no branch created.

---

## Overview

| Field | Value |
|-------|-------|
| Block name | `premium/[block-name]` |
| Tier | free / pro |
| Developer | |
| Branch | `feature/[block-name]` |
| Sprint | |
| Depends on | (other blocks or tasks that must finish first) |

---

## What this block does (user language)

Write 1-2 sentences describing what a non-technical WordPress user
can do with this block. No technical terms.

---

## What must be TRUE when this block is done

These are checked by `bash scripts/verify-block.sh [block-name]`
and by the reviewer before merge.

**Functional:**
- [ ] Block inserts without JavaScript errors in the editor
- [ ] Block saves and renders correctly on the frontend
- [ ] Block works in Full Site Editor (FSE) template context
- [ ] Block works in Classic post/page editor
- [ ] All inspector controls save and apply correctly

**Technical:**
- [ ] `useBlockProps` used in `edit.js`
- [ ] `useBlockProps.save` used in `save.js`
- [ ] No `console.log` or `debugger` statements
- [ ] No jQuery
- [ ] All styles scoped to `.wp-block-premium-[block-name]` wrapper
- [ ] No global CSS selectors that leak outside the block

**Accessibility:**
- [ ] Keyboard navigable
- [ ] Appropriate ARIA roles/labels where needed
- [ ] Passes axe-core with zero critical errors

---

## Files to create

| File | Purpose |
|------|---------|
| `src/blocks/[block-name]/index.js` | Block registration |
| `src/blocks/[block-name]/edit.js` | Editor component |
| `src/blocks/[block-name]/save.js` | Frontend render |
| `src/blocks/[block-name]/inspector.js` | Sidebar controls |
| `src/blocks/[block-name]/style.scss` | Frontend + editor shared styles |
| `src/blocks/[block-name]/styling.js` | Dynamic inline styles (if needed) |

---

## Inspector controls (Settings / Style / Advanced tabs)

**Settings tab** — content controls (what is shown):

| Control | Type | Attribute name | Default |
|---------|------|----------------|---------|
| | | | |

**Style tab** — visual controls (how it looks):

| Control | Type | Attribute name | Default |
|---------|------|----------------|---------|
| | | | |

**Advanced tab** — CSS class, HTML anchor only.

---

## What must NOT exist when done

- No `wp_enqueue_script` / `wp_enqueue_style` called globally for this block
- No inline `style=""` attributes set outside of `styling.js`
- No hardcoded colors that ignore the block's color controls
- No `console.log`, `debugger`, `alert()`
- No jQuery
- No deprecated WordPress APIs (`@wordpress/no-unsafe-wp-apis`)

---

## How to verify before opening PR

```bash
# Run the automated check
bash scripts/verify-block.sh [block-name]

# Run JS linting on the block files
npx wp-scripts lint-js src/blocks/[block-name]/

# Run SCSS linting on the block styles
npx wp-scripts lint-style src/blocks/[block-name]/style.scss
```

All checks must pass. Fix errors. Review warnings.
