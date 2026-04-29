# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.3.11] - 2026-04-29

### Added

- **`x-wirecn.toaster`:** fixed toast region (Sonner-style stack), CSS variables **`--normal-bg` / `--normal-text` / `--normal-border` / `--border-radius`**, variants **success**, **info**, **warning**, **error**, **loading** (inline SVG icons), optional **`position`** (`bottom-right`, `bottom-left`, `top-right`, `top-left`).
- **`window.toast`:** **`success`**, **`warning`**, **`error`**, **`info`**, **`loading`** (message + optional **`description`**, **`duration`**, **`duration: false`** to disable auto-dismiss), **`dismiss(id)`**; backed by **`Alpine.store('wirecnToast')`** (max 5, default durations per variant; **loading** has no auto-dismiss by default).
- **Livewire:** **`Livewire.on('wirecn-toast', …)`** (after **`livewire:init`**) and **`document`** event **`wirecn-toast`** with **`detail`** **`{ type, message | title, description?, duration? }`**.

## [1.0.3.10] - 2026-04-29

### Added

- **`x-wirecn.field`:** compound field primitives aligned with shadcn/ui Field — **`set`**, **`legend`**, **`group`**, **`field`**, **`content`**, **`label`** (wraps **`x-wirecn.label`**), **`title`**, **`description`**, **`separator`** (uses **`x-wirecn.separator`**), **`error`** (slot or **`errors`** iterable of messages / `message` keys, deduped).

## [1.0.3.9] - 2026-04-28

### Changed

- **`x-wirecn.combobox.content` / `list`:** the panel body scrolls via **`x-wirecn.scroll-area`** (viewport carries **`listbox`**, **`x-bind:id="listId"`**, **`tabindex="-1"`**, same padding/scroll affordance classes as select); **`combobox-list`** drops **`max-h-60` / `overflow-y-auto`** so height is capped by the floating panel and scrolling stays in the scroll-area viewport.

## [1.0.3.8] - 2026-04-28

### Changed

- **`x-wirecn.combobox.content`:** aligned with the select — **`x-teleport="body"`**, **`fixed`**, **`z-[100]`**, **`wire:ignore`**, **`x-ref="floatingPanel"`**, class merge via **`cn(..., $attributes->get('class'))`** + **`except('class')`**, **`x-transition.opacity.duration.100ms`**, **`transitionend`** to clear styles after close.
- **`uiCombobox`:** positioning via **`bindFloatingSelectPanel`** (same viewport **`flip` / `shift`** pipeline), **`x-ref="reference"`** on the input group (fallback **`input`**), **`mousedown.window`** outside **reference** + **floatingPanel** instead of **`pointerdown`** on `document`.

### Fixed

- **`bindFloatingSelectPanel`:** **`visibility: hidden`** until the first **`left` / `top`** application so the panel is not visible in the corner before Floating UI positions it.
- **`x-wirecn.select.content`:** transition aligned with the combobox — **`x-transition.opacity.duration.100ms`** instead of separate **`enter` / `leave`** blocks (**opacity** only, no **scale**).

## [1.0.3.7] - 2026-04-28

### Fixed

- **`uiSelect`:** on close, Floating UI **`autoUpdate`** stops immediately; **`left` / `top` / `position`** cleanup on the panel runs only on **`opacity`** **`transitionend`** on **`floatingPanel`** itself (with **`panelOpen`** already false), matching the real end of **`x-transition:leave`** — avoids a **`fixed`** panel with no coordinates visible in the corner and spurious closes from **`mousedown`** outside, with no **`setTimeout`** tied to CSS duration.

## [1.0.3.6] - 2026-04-28

### Fixed

- **`wirecnDialogScrollLock`:** in addition to **`overflow: hidden`** on **`html` / `body`**, applies **`overscroll-behavior: none`**, **`touch-action: none`** on **`body`**, and — when **`window.scrollY > 0`** — **`position: fixed`** on **`body`** with **`top: -scrollY`** to freeze page scroll; **`unlock`** restores everything and calls **`window.scrollTo(0, scrollY)`**. App scroll containers (e.g. **`main`** with **`overflow-y-auto`**) may set **`data-wirecn-scroll-lock`** to receive the same lock while a dialog or sheet is open.

## [1.0.3.5] - 2026-04-28

### Fixed

- **Select / Floating UI:** panel **`flip`** and **`shift`** use **`boundary`** = **Visual Viewport** rectangle (or `documentElement.clientWidth` / `Height`) + **`rootBoundary: 'viewport'`**, instead of relying only on the trigger’s **`clippingAncestors`** — usable space is the **screen**, not the dialog box with **`overflow-y-auto` / `overflow: hidden`**, and the panel flips **upward** near the bottom of the page when there is not enough room below.
- **Select:** positioning only after **two `requestAnimationFrame`** ticks and up to **20** retries while **`getBoundingClientRect().height < 1`** (avoids measuring while **`x-show`** has no layout yet); panel transitions are **opacity-only** (no **`scale-95`**) so Floating UI does not underestimate height during the animation.

## [1.0.3.4] - 2026-04-28

### Changed

- **Select (`x-wirecn.select.content`):** listbox back to **`x-teleport="body"`** with **`fixed`**, **`z-[100]`** (above dialogs/sheets at **`z-50`**), **`wire:ignore`**, explicit transitions, and **`x-ref="floatingPanel"`**. Base classes include **`max-h-[min(24rem,calc(100dvh-2rem))]`**; consumers can override with **`class="..."`** — merge via **`cn(..., $attributes->get('class'))`** + **`except('class')`** so tailwind-merge resolves conflicts (e.g. **`max-h-40`**).
- **`bindFloatingSelectPanel`:** **`strategy: 'fixed'`**, **`offset`**, **`flip({ padding: 8 })`** (opens upward near the bottom of the viewport when needed), **`shift({ padding: 8 })`**; no **`size`** middleware writing height as inline style. Panel width tracks the trigger (min 144px) respecting **`max-width`** (inline or computed).
- **`uiSelect`:** positioning with **`autoUpdate`**, **`unbindPanelPosition`** on close; **`onSelectPointerDownOutside`** considers **`reference`** and **`floatingPanel`**.

## [1.0.3.3] - 2026-04-28

### Changed

- **Select:** listbox back **in the component DOM** (`absolute top-full`, `wire:ignore`) instead of **`x-teleport="body"`** + Floating UI positioning; removed **`bindFloatingSelectPanel`**, panel cleanup, and **`x-ref="floatingPanel"`**; **`onSelectPointerDownOutside`** again uses **`this.$el.contains`** for outside clicks. Menus and tooltips keep **`strategy: 'fixed'`** where they still use a fixed layer.

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
