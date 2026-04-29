---
name: conventional-commits-workflow
description: >-
  Plans and executes local git commits using Conventional Commits in English.
  Push only when the user explicitly asks (e.g. push, publish, release to origin,
  or Portuguese: enviar, publicar). Covers SemVer, English CHANGELOG, tags, and
  composer.json version policy for this package.
---

# Conventional commits workflow

## SemVer: **MAJOR**, **MINOR**, or **PATCH**

Canonical format: **`MAJOR.MINOR.PATCH`** ([semver.org](https://semver.org/spec/v2.0.0.html)).

| Bump | When to use | Examples |
|------|----------------|----------|
| **MAJOR** | **Incompatible** changes to the public API consumers rely on: rename/remove published Blade components, change prefix/namespace, remove required props or break PHP contracts, change default behaviour so apps must change code. | `x-wirecn.foo` → `x-wirecn.bar`; remove `wirecnDialogScrollLock`; change a public helper signature. |
| **MINOR** | **New** **backward-compatible** capabilities: new component, optional prop, new JS export, API improvements that do not require existing integrators to change. | New `x-wirecn.badge`; optional dialog attribute; new opt-in Alpine middleware. |
| **PATCH** | **Fixes** and tweaks that **do not** change the expected contract: bugs, regressions, docs, internal performance, alignment with existing docs. | Fix scroll lock; fix select positioning; README typos. |

**Pre-1.0 (`0.y.z`):** `MINOR` may include smaller breaking changes; `PATCH` is for fixes. After **1.0.0**, apply the table strictly.

**Wirecn / Git tags:** this repo has used **`1.0.3.x`** (four segments), which is **not** classic SemVer and can confuse Packagist/comparators. Prefer moving new tags to **`MAJOR.MINOR.PATCH`** (e.g. `1.0.4` after `1.0.3.5`) unless the project explicitly keeps the extra segment; keep **`CHANGELOG.md`** and **`composer.json`** `version` (if present) aligned with the same string.

## Where to bump version

- **`composer.json`:** in **wirecn/laravel-wirecn**, the **`"version"`** field is **intentionally omitted** (avoid mismatch with tags and Packagist skipping tags). Published versions follow **Git tags** (`v1.0.3.7`, etc.) and **`CHANGELOG.md`**.
- In other projects, if `"version"` exists in `composer.json`, keep it **consistent** with changelog and tag.

Release commits use English headers (see below). Add a **`[X.Y.Z]`** section under **`CHANGELOG.md`** and tag **`vX.Y.Z`** when doing a numbered release. **Push** (including **`--force-with-lease`** / tag force) only when the user **explicitly** asks — e.g. “push”, “publish”, “release”, “to origin”, or Portuguese: *enviar*, *publicar*, *fazer push*.

## Changelog language

- **`CHANGELOG.md`** for **wirecn** is maintained in **English** (Keep a Changelog style, international consumers).
- New **`[Unreleased]`** and release sections: write bullets in **English**.

## Literal user prompt (Portuguese — optional)

When the user asks in these terms, follow them (including **no push** unless they later ask to push):

_Com base nos arquivos modificados, crie uma cronologia de commits, mas sem realizar o push. Os commits deverão ser em inglês e seguir o padrão de conventional commits: `type(scope): description`._

## Rules

1. **Inspect** `git status` and `git diff` (and `git diff --cached` if staged).
2. **Propose** a sequence: small, coherent commits, one purpose each (group by domain: code vs docs vs config vs version bump).
3. **Execute** commits locally in that order: selective `git add`, then `git commit -m "..."`.
4. **Messages:** English only; header `type(scope): description` (scope when helpful; imperative description; no trailing period in the title).
5. **Common types:** `feat`, `fix`, `docs`, `style`, `refactor`, `perf`, `test`, `build`, `ci`, `chore`, `revert`. Use **`docs(changelog): ...`** for CHANGELOG-only edits.
6. **Do not** run `git push` (or `--force`) unless the user explicitly requests it afterward.

## Example headers

- `feat(blade): add wirecn button component`
- `fix(merge): handle arbitrary class order in cn()`
- `docs(changelog): translate entries to English`
- `chore(composer): bump version to 0.2.0`

## Notes

- Do not include `vendor/` changes if ignored; respect project `.gitignore`.
- If there are no changes, explain and do not create empty commits.
- **Force-pushing** rewritten tags (`vX.Y.Z`) breaks consumers pinning that tag; only do it when the user explicitly wants to replace a release.
