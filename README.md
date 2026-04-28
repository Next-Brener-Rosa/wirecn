# livecn / laravel-livecn

Blade UI components for Laravel with Tailwind-friendly class merging via **`cn()`** ([tailwind-merge-php](https://github.com/gehrisandro/tailwind-merge-php)) and Alpine.js behaviours shipped as publishable JavaScript stubs.

## Requirements

- PHP `^8.3`
- Laravel `^12` or `^13` (Illuminate View / Support)
- Tailwind CSS v4 (or compatible) with your design tokens (`bg-popover`, `text-muted-foreground`, etc.)

## Install

```bash
composer require livecn/laravel-livecn
```

Publish **views** (required for the default workflow — components live in your app):

```bash
php artisan vendor:publish --tag=livecn-views
```

Publish **JavaScript** (Alpine primitives, optional chart/phosphor islands):

```bash
php artisan vendor:publish --tag=livecn-js
```

Then import Alpine (and islands if you use them) from your Vite entry, for example:

```js
import './livecn/alpine-ui.js';
```

Ensure Tailwind scans published components:

```js
// tailwind.config / @source in CSS — example
'./resources/views/components/livecn/**/*.blade.php',
```

### NPM peers (optional features)

If you use **charts** (`<x-livecn.chart>`) or **Phosphor** (`<x-livecn.phosphor-icon>`), align versions with your app’s `package.json` (React, `@vitejs/plugin-react`, Recharts, `@phosphor-icons/react`, etc.). See your application template for exact pins.

## Usage

After publishing, use dot notation for nested components:

```blade
<x-livecn.input class="max-w-sm" name="email" type="email" />
<x-livecn.button variant="default">Save</x-livecn.button>
<x-livecn.dropdown-menu.item>...</x-livecn.dropdown-menu.item>
```

`class` and other HTML attributes are forwarded where each stub uses `$attributes->class(cn(...))`.

## Updates

| Layer | What updates | How |
|-------|----------------|-----|
| **PHP** (`cn()`, `Livecn\Laravel\Support\UiIcon`, service provider) | `composer update livecn/laravel-livecn` | SemVer tags on Packagist. |
| **Published Blade / JS** | Files under `resources/views/components/livecn/` and `resources/js/livecn/` | **Not** overwritten by Composer. For upstream template fixes, read **CHANGELOG**, then re-run `vendor:publish --tag=livecn-views --force` (backup first if you customised) or merge diffs manually. |

Use [SemVer](https://semver.org/): patch for bugfixes, minor for backwards-compatible additions, major for breaking PHP or Blade contracts.

## Packagist (public)

Submit this repository (or a split mirror with this package at the Git root) to [Packagist](https://packagist.org). During local development you can use a Composer **path** repository pointing at this directory.

## License

MIT
