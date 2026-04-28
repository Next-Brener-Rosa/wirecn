# wirecn / laravel-wirecn

Blade UI components for Laravel with Tailwind-friendly class merging via **`cn()`** ([tailwind-merge-php](https://github.com/gehrisandro/tailwind-merge-php)) and Alpine.js behaviours shipped as publishable JavaScript stubs.

## Requirements

- PHP `^8.3`
- Laravel `^12` or `^13` (Illuminate View / Support)
- Tailwind CSS v4 (or compatible) with your design tokens (`bg-popover`, `text-muted-foreground`, etc.)

## Install

```bash
composer require wirecn/laravel-wirecn:^1.0
```

### `minimum-stability: stable` + repositório `path`

Sem tag Git, o Composer trata o pacote local como `dev-*`, o que **falha** com `minimum-stability: stable` no projecto consumidor. Este pacote declara **`"version": "1.0.0"`** no `composer.json` para repositórios **`path`** satisfazerem `^1.0` / `stable`. Em **Packagist**, a versão publicada vem da **tag Git** (`v1.0.0`, …); mantém o campo `version` alinhado com a última tag estável ou remove-o se usares só tags (recomendado na doc do Composer para pacotes só-VCS).

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

### NPM dependencies

Composer does **not** install these. After `vendor:publish --tag=wirecn-js`, stubs live under `resources/js/wirecn/`. Install packages in **your app** root (`package.json`).

#### Required if you import `alpine-ui.js`

Used directly by the published bundle:

| Package | Role |
|---------|--------|
| [`embla-carousel`](https://www.embla-carousel.com/) | `<x-wirecn.carousel.*>` |
| [`@floating-ui/dom`](https://floating-ui.com/) | Floating overlays (dropdowns, popovers, tooltips, command palette positioning, etc.) |

```bash
npm install embla-carousel @floating-ui/dom
```

#### Optional — Phosphor icons

Needed when you render `<x-wirecn.phosphor-icon>` (and defaults like `<x-wirecn.icon>` that delegate to it).

| Package | Role |
|---------|--------|
| `react`, `react-dom` | `phosphor-island.jsx` mounts icons with `createRoot` |
| [`@phosphor-icons/react`](https://phosphoricons.com/) | Icon modules; `phosphor-registry.jsx` uses `import.meta.glob` over `node_modules/@phosphor-icons/react/dist/csr/*.es.js` (path is relative to **`resources/js/wirecn/`** → your app’s `node_modules`) |

Vite: add [`@vitejs/plugin-react`](https://github.com/vitejs/vite-plugin-react) and ensure `.jsx` under `resources/js/wirecn/` is compiled (same React major as your app).

Example (run after DOM ready; call again after Turbo / Livewire navigations if icons are injected later):

```js
import { initPhosphorIcons } from './wirecn/phosphor-island.jsx';

void initPhosphorIcons();
```

#### Optional — Charts

Needed for `<x-wirecn.chart>` (`data-ui-chart` nodes).

| Package | Role |
|---------|--------|
| `react`, `react-dom` | Same as above if not already installed |
| [`recharts`](https://recharts.org/) | Chart primitives in `chart-island.jsx` |

```js
import { initUiCharts } from './wirecn/chart-island.jsx';

initUiCharts();
```

#### Versions and licensing

wirecn does not ship a `package.json` for your app: **pin versions** next to your Laravel / Vite / React stack. When upgrading wirecn, re-publish or diff stubs, then adjust npm ranges if builds fail.

Third-party docs: [Embla](https://www.embla-carousel.com/), [Floating UI](https://floating-ui.com/), [Phosphor](https://phosphoricons.com/), [Recharts](https://recharts.org/). You do not need to copy their APIs into this README—only install what you use and wire the init helpers above.

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
