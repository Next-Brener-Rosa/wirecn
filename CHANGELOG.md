# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.3.6] - 2026-04-28

### Fixed

- **`wirecnDialogScrollLock`:** além de `overflow: hidden` em `html`/`body`, aplica-se **`overscroll-behavior: none`**, **`touch-action: none`** no `body`, e — quando **`window.scrollY > 0`** — **`position: fixed`** no `body` com **`top: -scrollY`** para congelar o scroll da página; no `unlock` restaura-se tudo e chama-se **`window.scrollTo(0, scrollY)`**. Contentores de scroll da app (ex.: `main` com **`overflow-y-auto`**) podem declarar **`data-wirecn-scroll-lock`** para receberem o mesmo bloqueio enquanto um dialog/sheet estiver aberto.

## [1.0.3.5] - 2026-04-28

### Fixed

- **Select / Floating UI:** `flip` e `shift` do painel usam **`boundary`** = retângulo do **Visual Viewport** (ou `documentElement.clientWidth`/`Height`) + **`rootBoundary: 'viewport'`**, em vez de confiar só em **`clippingAncestors`** do trigger — assim o espaço útil é o **ecrã**, não a caixa do dialog com **`overflow-y-auto` / `overflow: hidden`**, e o painel abre para **cima** junto ao fundo da página quando falta espaço por baixo.
- **Select:** posicionamento só depois de **dois `requestAnimationFrame`** e até **20** tentativas enquanto **`getBoundingClientRect().height < 1`** (evita medir com **`x-show`** ainda sem layout); transições do painel passam a **só opacidade** (sem **`scale-95`**), para o Floating UI não subestimar a altura durante a animação.

## [1.0.3.4] - 2026-04-28

### Changed

- **Select (`x-wirecn.select.content`):** listbox volta a **`x-teleport="body"`** com **`fixed`**, **`z-[100]`** (acima de dialogs/sheets em **`z-50`**), **`wire:ignore`**, transições explícitas e **`x-ref="floatingPanel"`**. Classes base incluem **`max-h-[min(24rem,calc(100dvh-2rem))]`**; o consumidor pode sobrescrever com **`class="..."`** — merge via **`cn(..., $attributes->get('class'))`** + **`except('class')`** para o tailwind-merge resolver conflitos (ex.: **`max-h-40`**).
- **`bindFloatingSelectPanel`:** **`strategy: 'fixed'`**, **`offset`**, **`flip({ padding: 8 })`** (abre para cima junto ao fundo do viewport quando necessário), **`shift({ padding: 8 })`**; sem middleware **`size`** a definir altura em estilo inline. Largura do painel alinhada ao trigger (mín. 144px) com respeito a **`max-width`** (inline ou computado).
- **`uiSelect`:** posicionamento com **`autoUpdate`**, **`unbindPanelPosition`** ao fechar; **`onSelectPointerDownOutside`** considera **`reference`** e **`floatingPanel`**.

## [1.0.3.3] - 2026-04-28

### Changed

- **Select:** listbox de volta **no DOM do componente** (`absolute top-full`, `wire:ignore`) em vez de **`x-teleport="body"`** + posicionamento Floating UI; removidos **`bindFloatingSelectPanel`**, cleanup do painel e **`x-ref="floatingPanel"`**; **`onSelectPointerDownOutside`** volta a usar **`this.$el.contains`** para cliques fora. Menus e tooltips mantêm **`strategy: 'fixed'`** onde ainda usam camada fixa.

## [1.0.3.2] - 2026-04-28

### Fixed

- **Floating UI + `position: fixed`:** pass **`strategy: 'fixed'`** to **`computePosition`** in **`bindFloatingSelectPanel`**, **`bindFloatingMenu`**, and **`bindFloatingTooltip`**. Teleported select listboxes and other fixed layers now align with the trigger when it sits inside a **transformed** ancestor (e.g. centred dialog); without this, coordinates assumed an absolute box and the panel could jump to a viewport corner.

## [1.0.3.1] - 2026-04-28

### Changed

- **`wirecnDialogScrollLock`:** implementation reduced to **`html`** / **`body`** `overflow` save/restore only (no **`padding-right`** scrollbar compensation). Exposed as **`const wirecnDialogScrollLock`** plus **`window.wirecnDialogScrollLock`** for Blade / debug.
- **`uiDialog`:** scroll lock wired with **`alpine:destroy`** on the root element (once) instead of Alpine **`destroy()`** on the data object; calls **`wirecnDialogScrollLock.lock()`** / **`unlock()`** from module scope.
- **`uiCommandDialog`:** scroll lock removed (command palette no longer toggles document overflow).
- **`bindFloatingMenu`:** dropped optional **`sameWidth`** / fifth-argument branch (back to fixed position + x/y only).
- **`bindFloatingSelectPanel`:** **`size`** middleware sets **`maxHeight`** / **`maxWidth`** from available space with fixed padding and minimums; width from trigger vs **`maxWidth`**; removed **`getComputedStyle`** merge for Tailwind **`max-h-*`** on the panel.
- **`uiSelect`:** clear floating panel inline styles with empty strings; drop redundant post-open **`refreshOptions`** pass; remove **`destroy()`** hook (position cleanup runs when the panel closes).

### Fixed

- Background page scroll while dialogs are open: lock/unlock flow aligned with Alpine lifecycle (**`alpine:destroy`**) so depth is not left inconsistent after Livewire navigation.

## [1.0.3] - 2026-04-28

### Changed

- **Modal document scroll lock:** replaced **`wirecnLockModalScroll`** / **`wirecnUnlockModalScroll`** with **`window.wirecnDialogScrollLock`** exposing **`lock()`** and **`unlock()`** (same depth-counted behaviour: save/restore **`document.documentElement`** and **`document.body`** overflow and scrollbar gutter). **`uiDialog`**, **`uiCommandDialog`**, and Livewire **`wire:model`** branches on **dialog**, **alert-dialog**, and **sheet** now call this API.

## [1.0.2] - 2026-04-28

### Added

- **`scroll-area`:** optional `viewportRef` and `viewportAttributes` for Alpine/A11y on the viewport (used by the select listbox).
- **`wirecnLockModalScroll`** / **`wirecnUnlockModalScroll`** on **`window`** (reference-counted): lock **`html`** / **`body`** overflow while a modal is open so the page behind does not scroll; restores scrollbar gutter via **`padding-right`** when needed.

### Changed

- **Select:** listbox panel teleported to `body` with **`bindFloatingSelectPanel`** (Floating UI `offset`, `flip`, `shift`, **`size`**), `floatingPanel` ref, `z-[100]`, flex layout, and **`x-wirecn.scroll-area`** for option scrolling; outside close via **`mousedown.window`** on the select root. Removed dedicated **`select/portal`** stub in favour of inline teleport.
- **`uiDialog`** and **`uiCommandDialog`:** call the modal scroll lock when **`open`** is true; **`destroy`** unlocks if still open.
- **Dialog / alert-dialog / sheet** (overlays and alert wrapper): explicit **`100vh` × `100vw`** with **`overflow-hidden`** / **`overscroll-contain`** so the portal layer matches the visual viewport, not the scrolled document height.
- **Dialog content:** **`max-h-[calc(100vh-2rem)]`**, **`max-w-[calc(100vw-2rem)]`**, and scroll inside the panel when content is tall.
- **Command dialog:** outer portal uses viewport box; backdrop and scroll region use **`absolute inset-0`** inside it.
- **Dialog, alert-dialog, sheet** with **`wire:model`:** same **`init` / `$watch('open')` / `destroy`** hookup for scroll lock as **`uiDialog`**.

### Fixed

- Select floating panel **`max-h-*` / `max-w-*`** on `<x-wirecn.select.content>` are respected again (merged with viewport bounds instead of being overridden by inline `size` output).
- Listbox no longer clipped by modal/dialog **`overflow`** when using the new layer.
- Modal portals no longer depend on the underlying document scroll for backdrop sizing; background scroll is disabled while dialogs are open.

## [1.0.1] - 2026-04-28

### Fixed

- Removed root `composer.json` **`version`** so Packagist no longer skips Git tags when the field and the tag disagree (e.g. tag `1.0.0` vs `1.0.1` in JSON).

## [1.0.0] - 2026-04-28

First **stable** release as `wirecn/laravel-wirecn` — install with `composer require wirecn/laravel-wirecn:^1.0` (no `@dev`) once Packagist or your Git remote exposes tag **`v1.0.0`**.

### Added

- Documented NPM dependencies for published `wirecn-js` (Embla, Floating UI, optional Phosphor / Recharts).

### Changed

- Package renamed from `livecn/laravel-livecn` to **`wirecn/laravel-wirecn`**; PHP namespace **`Wirecn\Laravel`**; Blade prefix **`x-wirecn.*`**; publish tags **`wirecn-views`** / **`wirecn-js`**.

## [0.1.0] - 2026-04-28

### Added

- Initial prerelease (as **livecn**): `cn()` helper, `UiIcon`, publishable Blade and JS stubs. Superseded for consumers by **[1.0.0]** under the **wirecn** vendor.
