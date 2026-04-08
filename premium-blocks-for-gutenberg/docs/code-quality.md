# Code Quality Tools — Team Guide

This document explains every code quality tool used in this project:
what it does, why it exists, how to install it, and how to use it daily.

Read this once. Keep it open your first week.

---

## Table of Contents

1. [First Time Setup — Start Here](#first-time-setup)
2. [The Big Picture](#the-big-picture)
3. [ESLint — JavaScript quality checker](#eslint)
4. [StyleLint — SCSS quality checker](#stylelint)
5. [Prettier — Code formatter](#prettier)
6. [Quick Reference Card](#quick-reference-card)

---

## First Time Setup

**Every developer must run these commands once after cloning the repo.**

### Step 1 — Install Node.js tools

```bash
npm install
```

This single command installs **everything**: ESLint, StyleLint, Webpack,
and all JavaScript tools. They all come bundled inside `@wordpress/scripts`,
which is already listed in `package.json`. You do not install ESLint or
StyleLint separately.

### Step 2 — Install PHP tools

```bash
composer install
```

This installs PHP CodeSniffer and WordPress Coding Standards.
Required for PHP linting (covered in a separate document).

### Step 3 — Verify it works

```bash
npm run lint:js
npm run lint:scss
```

You should see a list of issues in the output — that is correct and expected.
What you should NOT see is `command not found` or `Cannot find module`.

If either of those errors appear, re-run `npm install` and ask in Slack
before touching any code.

### What you do NOT need to install separately

| Tool | Status | Why |
|------|--------|-----|
| ESLint | Already included | Comes inside `@wordpress/scripts` |
| StyleLint | Already included | Comes inside `@wordpress/scripts` |
| Prettier | Already included | Installed as `prettier` in `package.json` |

### VS Code extensions (strongly recommended)

These show lint errors as red underlines in your editor as you type —
before you even run a command:

1. Open VS Code
2. Press `Cmd+Shift+X` (Mac) or `Ctrl+Shift+X` (Windows) to open Extensions
3. Search and install:
   - `ESLint` by Microsoft (ID: `dbaeumer.vscode-eslint`)
   - `Stylelint` by Stylelint (ID: `stylelint.vscode-stylelint`)

Once installed, open any `.js` or `.scss` file — problems appear with
a red or yellow underline immediately, no command needed.

---

## The Big Picture

We use three separate tools for three separate jobs:

| Tool | Language | Job |
|------|----------|-----|
| ESLint | JavaScript / JSX | Finds bugs and bad patterns |
| StyleLint | SCSS / CSS | Finds bad stylesheet patterns |
| Prettier | JS + SCSS | Formats code automatically |

Think of it this way:
- **ESLint** catches things that are *wrong* or *risky*
- **StyleLint** catches SCSS that is *broken* or *redundant*
- **Prettier** makes all code *look the same* regardless of who wrote it

They work together. They do not replace each other.

---

## ESLint

### What is it?

ESLint reads your JavaScript and JSX files and reports problems — unused
variables, unsafe comparisons, missing imports, deprecated WordPress APIs.

It does not run your code. It reads it statically, like a code reviewer
that never gets tired and never misses a pattern.

### Why do we have it?

Without ESLint:
- A developer commits `if (x == null)` instead of `if (x === null)` — silent bug
- An unused variable accumulates across 20 files — dead code
- A `console.log('debug')` ships to production — unprofessional
- Every developer structures imports differently — messy reviews

With ESLint:
- These are flagged before code is reviewed by a human
- Code reviews focus on logic, not syntax
- New developers get instant feedback on conventions

### Is it already installed?

Yes. ESLint comes bundled inside `@wordpress/scripts`, which is already
in the project. You do not need to install anything.

### How to run it

```bash
# Check for problems (does not change any files)
npm run lint:js

# Show only errors, not warnings
npm run lint:js -- --quiet

# Auto-fix problems that can be fixed automatically
npm run lint:js:fix

# Check a single file
npx wp-scripts lint-js src/blocks/heading/edit.js
```

### How to read the output

```
src/blocks/heading/edit.js
  42:5  warning  'fontSize' is defined but never used   no-unused-vars
  67:9  warning  Expected '===' and instead saw '=='    eqeqeq
  81:3  error    'myFunc' is not defined                no-undef
```

- `42:5` — line 42, column 5 in the file
- `warning` — should fix; will not block commits yet
- `error` — must fix; will block CI when fully enforced
- `no-unused-vars` — the name of the rule that triggered

### What ESLint checks in this project

**Errors (must fix):**
- Variables or functions used before they are defined (`no-undef`)
- Imports that cannot be resolved (`import/no-unresolved`)
- Missing dependencies in `useEffect` and `useCallback` (`react-hooks/exhaustive-deps`)

**Warnings (fix in new code you write; fix old code when you touch it):**
- Using `==` instead of `===` (`eqeqeq`)
- Variables declared but never used (`no-unused-vars`)
- `console.log` left in code (`no-console`)
- Variable names shadowing outer scope variables (`no-shadow`)
- Non-camelCase variable names (`camelcase`)
- Using internal WordPress APIs not meant for plugins (`@wordpress/no-unsafe-wp-apis`)

### What ESLint does NOT check

- Whether the block renders correctly in the browser — that is E2E testing
- PHP code — that is phpcs
- Whether styles look right — that is StyleLint

### Config file

`.eslintrc.js` in the root of the plugin. Do not edit this without discussing
with the team first. Rule changes affect everyone.

`.eslintignore` lists files and folders ESLint skips (build output, vendor code).

---

## StyleLint

### What is it?

StyleLint reads your `.scss` files and reports problems — duplicate selectors,
empty blocks, duplicate properties, redundant nesting.

### Why do we have it?

SCSS errors are harder to spot than JS errors because bad SCSS usually still
compiles and renders. Problems accumulate silently:

- Two developers define `.premium-hero` in different parts of a file — one
  silently overrides the other
- An empty `.premium-card {}` block sits in the file doing nothing — dead code
- The same CSS property is set twice in one rule — one value is always ignored

StyleLint catches all of these automatically.

### Is it already installed?

Yes. StyleLint comes bundled inside `@wordpress/scripts`. No installation needed.

### How to run it

```bash
# Check all SCSS files for problems
npm run lint:scss

# Auto-fix problems that can be fixed automatically
npm run lint:scss:fix

# Check a single file
npx wp-scripts lint-style src/blocks/heading/style.scss
```

### How to read the output

```
src/blocks/form/style.scss
  224:1  error  Unexpected duplicate selector ".rdrDayDisabled"   no-duplicate-selectors
  45:3   error  Unexpected empty block                            block-no-empty
```

### What StyleLint checks in this project

**Active errors (must fix):**
- Same selector defined twice in one file (`no-duplicate-selectors`)
- Same CSS property set twice in one rule (`declaration-block-no-duplicate-properties`)
- Empty CSS blocks `{}` with nothing inside (`block-no-empty`)
- Redundant SCSS nesting like `& .child` when `.child` works (`scss/selector-no-redundant-nesting-selector`)

**Intentionally turned off (existing codebase compatibility):**
- Indentation style (tabs vs spaces)
- Quote style around values
- Spacing inside functions
- Color format (hex shorthand vs full hex)
- Line breaks between rules

These will be re-enabled gradually as the codebase is cleaned up.

### Config file

`.stylelintrc.json` in the root of the plugin.

---

## Prettier

### What is it?

Prettier is a code *formatter*, not a linter. It does not find bugs.
It reformats your code to look consistent — same indentation, same quote style,
same line length — regardless of who wrote it.

The difference:
- ESLint says "this code has a problem" — you decide how to fix it
- Prettier says "I will reformat this code" — it does it for you, automatically

### Why does it matter?

Right now, our ESLint config has 12 formatting rules turned off:

```js
quotes: 'off',
'comma-dangle': 'off',
'key-spacing': 'off',
// ... 9 more
```

These are off because the existing codebase uses spaces (4-space indentation)
and the WordPress standard uses tabs. ESLint cannot enforce both at once.

Prettier solves this cleanly. You configure it once, run it once on all
files, and from that point forward everyone's editor auto-formats on save.
The 12 `'off'` rules in `.eslintrc.js` get deleted entirely.

### Is it installed?

Yes. Prettier v3 is installed. Config file is `.prettierrc.js` in the root.

### Important — one-time bulk reformat needed

Prettier is installed but **not yet applied** to the codebase.
524 existing files do not match the Prettier format yet.

Before the team runs `npm run format` for the first time, agree on a time
to do it together — it creates a large diff that will conflict with any
open branches. The steps are:

1. Make sure all open PRs are merged or rebased first
2. One person runs `npm run format` on the `develop` branch
3. Commit as a single dedicated commit: `style: apply Prettier formatting`
4. All other developers rebase their branches onto the updated `develop`

After that one-time event, Prettier runs normally on new code.

### VS Code setup

Install the [Prettier VS Code extension](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode)
(ID: `esbenp.prettier-vscode`).

Then add to your VS Code settings (`.vscode/settings.json`):

```json
{
    "editor.formatOnSave": true,
    "editor.defaultFormatter": "esbenp.prettier-vscode"
}
```

Your editor will auto-format every file on save. You will never need to
run `npm run format` manually in day-to-day work.

### What Prettier does NOT do

- It does not catch bugs — that is ESLint's job
- It does not check SCSS logic — that is StyleLint's job
- It does not run tests

---

## Quick Reference Card

Copy this into your team chat.

```
ESLint (JS/JSX)
  npm run lint:js          — check for problems
  npm run lint:js:fix      — auto-fix what can be fixed

StyleLint (SCSS)
  npm run lint:scss         — check for problems
  npm run lint:scss:fix     — auto-fix what can be fixed

Rule of thumb:
  Run both before opening a pull request.
  Fix errors. Fix warnings in any file you touch.
  Do not add new warnings in new code.
```

---

## Team Rules

1. **Run lint before every PR.** Not after. The reviewer should not be the
   first person to see lint errors.

2. **Fix errors always.** Warnings in new code you write should also be fixed.
   Warnings in old code you did not touch can wait for a dedicated cleanup ticket.

3. **Do not disable rules inline** (`// eslint-disable-next-line`) without
   a comment explaining why. Silencing a rule without explanation is the same
   as ignoring the problem.

4. **Do not edit the config files** (`.eslintrc.js`, `.stylelintrc.json`)
   without a team discussion. One person changing a rule affects everyone's
   working files.

5. **When in doubt, ask.** A five-minute Slack conversation prevents a bad
   pattern from spreading across 61 blocks.
