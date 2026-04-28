# wirecn / laravel-wirecn

Blade UI components for Laravel with Tailwind-friendly class merging via **`cn()`** ([tailwind-merge-php](https://github.com/gehrisandro/tailwind-merge-php)) and Alpine.js behaviours shipped as publishable JavaScript stubs.

## Requirements

- PHP `^8.3`
- Laravel `^12` or `^13` (Illuminate View / Support)
- Tailwind CSS v4 (or compatible) with your design tokens (`bg-popover`, `text-muted-foreground`, etc.)

## Install

```bash
composer require wirecn/laravel-wirecn
```

### `minimum-stability: stable` + repositório `path`

Sem tag Git, o Composer trata o pacote local como `dev-*`, o que **falha** com `minimum-stability: stable` no projecto consumidor. Este pacote declara **`"version": "0.1.0"`** no `composer.json` para o `path` satisfazer `^0.1` / `stable`. Em **Packagist**, as versões vêm das **tags Git** (`v0.1.0`, …); ao publicar o repo, incrementa a tag e alinha o campo `version` ou remove-o se usares só tags (recomendado na doc do Composer para pacotes só-VCS).

Publish **views** (required for the default workflow — components live in your app):

```bash
php artisan vendor:publish --tag=wirecn-views
```

Publish **JavaScript** (Alpine primitives, optional chart/phosphor islands):

```bash
php artisan vendor:publish --tag=wirecn-js
```

Then import Alpine (and islands if you use them) from your Vite entry, for example:

```js
import './wirecn/alpine-ui.js';
```

Ensure Tailwind scans published components:

```js
// tailwind.config / @source in CSS — example
'./resources/views/components/wirecn/**/*.blade.php',
```

### NPM peers (optional features)

If you use **charts** (`<x-wirecn.chart>`) or **Phosphor** (`<x-wirecn.phosphor-icon>`), align versions with your app’s `package.json` (React, `@vitejs/plugin-react`, Recharts, `@phosphor-icons/react`, etc.). See your application template for exact pins.

## Usage

After publishing, use dot notation for nested components:

```blade
<x-wirecn.input class="max-w-sm" name="email" type="email" />
<x-wirecn.button variant="default">Save</x-wirecn.button>
<x-wirecn.dropdown-menu.item>...</x-wirecn.dropdown-menu.item>
```

`class` and other HTML attributes are forwarded where each stub uses `$attributes->class(cn(...))`.

## Updates

| Layer | What updates | How |
|-------|----------------|-----|
| **PHP** (`cn()`, `Wirecn\Laravel\Support\UiIcon`, service provider) | `composer update wirecn/laravel-wirecn` | SemVer tags on Packagist. |
| **Published Blade / JS** | Files under `resources/views/components/wirecn/` and `resources/js/wirecn/` | **Not** overwritten by Composer. For upstream template fixes, read **CHANGELOG**, then re-run `vendor:publish --tag=wirecn-views --force` (backup first if you customised) or merge diffs manually. |

Use [SemVer](https://semver.org/): patch for bugfixes, minor for backwards-compatible additions, major for breaking PHP or Blade contracts.

## Packagist (public)

Submit this repository (or a split mirror with this package at the Git root) to [Packagist](https://packagist.org). During local development you can use a Composer **path** repository pointing at this directory.

## License

MIT
