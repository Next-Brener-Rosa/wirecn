import EmblaCarousel from 'embla-carousel';
import { arrow, autoUpdate, computePosition, flip, offset, shift, size } from '@floating-ui/dom';

window.uiFloatingUi = { arrow, autoUpdate, computePosition, flip, offset, shift, size };

function bindFloatingMenu(referenceEl, floatingEl, placement, offsetOptions = { mainAxis: 4, crossAxis: 0 }, extra = {}) {
    const sameWidth = Boolean(extra.sameWidth);

    return window.uiFloatingUi.autoUpdate(referenceEl, floatingEl, async () => {
        const { x, y } = await window.uiFloatingUi.computePosition(referenceEl, floatingEl, {
            placement,
            middleware: [
                window.uiFloatingUi.offset(offsetOptions),
                window.uiFloatingUi.flip(),
                window.uiFloatingUi.shift({ padding: 8 }),
            ],
        });

        const style = {
            position: 'fixed',
            left: `${x}px`,
            top: `${y}px`,
        };

        if (sameWidth) {
            style.width = `${referenceEl.offsetWidth}px`;
        }

        Object.assign(floatingEl.style, style);
    });
}

function bindFloating(referenceEl, floatingEl, placement = 'bottom-start') {
    return bindFloatingMenu(referenceEl, floatingEl, placement, { mainAxis: 4, crossAxis: 0 });
}

function maxCssLengthToPx(value) {
    if (!value || value === 'none') {
        return Number.POSITIVE_INFINITY;
    }

    const n = parseFloat(value);

    return Number.isFinite(n) ? n : Number.POSITIVE_INFINITY;
}

/** Select listbox: fixed layer + viewport bounds (modals / overflow). */
function bindFloatingSelectPanel(referenceEl, floatingEl) {
    const edgeMargin = 12;

    return window.uiFloatingUi.autoUpdate(referenceEl, floatingEl, async () => {
        floatingEl.style.removeProperty('max-height');
        floatingEl.style.removeProperty('max-width');

        const cs = getComputedStyle(floatingEl);
        const userMaxH = maxCssLengthToPx(cs.maxHeight);
        const userMaxW = maxCssLengthToPx(cs.maxWidth);

        const { x, y } = await window.uiFloatingUi.computePosition(referenceEl, floatingEl, {
            placement: 'bottom-start',
            middleware: [
                window.uiFloatingUi.offset({ mainAxis: 4, crossAxis: 0 }),
                window.uiFloatingUi.flip(),
                window.uiFloatingUi.shift({ padding: 8 }),
                window.uiFloatingUi.size({
                    apply({ availableWidth, availableHeight, elements }) {
                        const availH = Math.max(0, availableHeight - edgeMargin);
                        const availW = Math.max(0, availableWidth - edgeMargin);

                        Object.assign(elements.floating.style, {
                            maxWidth: `${Math.min(availW, userMaxW)}px`,
                            maxHeight: `${Math.min(availH, userMaxH)}px`,
                        });
                    },
                }),
            ],
        });

        const maxWidthPx = parseFloat(floatingEl.style.maxWidth);
        const maxW = Number.isFinite(maxWidthPx) ? maxWidthPx : Number.POSITIVE_INFINITY;
        const triggerW = referenceEl.offsetWidth;
        const w = Math.min(Math.max(triggerW, 144), maxW);

        Object.assign(floatingEl.style, {
            position: 'fixed',
            left: `${x}px`,
            top: `${y}px`,
            width: `${w}px`,
        });
    });
}

function bindFloatingTooltip(referenceEl, floatingEl, arrowEl, placement, offsetOptions = { mainAxis: 4, crossAxis: 0 }) {
    return window.uiFloatingUi.autoUpdate(referenceEl, floatingEl, async () => {
        const middleware = [
            window.uiFloatingUi.offset(offsetOptions),
            window.uiFloatingUi.flip(),
            window.uiFloatingUi.shift({ padding: 8 }),
        ];

        if (arrowEl) {
            middleware.push(
                window.uiFloatingUi.arrow({
                    element: arrowEl,
                    padding: 4,
                }),
            );
        }

        const { x, y, placement: resolvedPlacement, middlewareData } = await window.uiFloatingUi.computePosition(
            referenceEl,
            floatingEl,
            {
                placement,
                middleware,
            },
        );

        Object.assign(floatingEl.style, {
            position: 'fixed',
            left: `${x}px`,
            top: `${y}px`,
        });

        const baseSide = resolvedPlacement.split('-')[0];

        floatingEl.dataset.side = baseSide;

        if (arrowEl) {
            arrowEl.dataset.side = baseSide;
        }

        if (arrowEl && middlewareData.arrow) {
            const { x: arrowX, y: arrowY } = middlewareData.arrow;
            const staticSide = {
                top: 'bottom',
                right: 'left',
                bottom: 'top',
                left: 'right',
            }[baseSide];

            Object.assign(arrowEl.style, {
                position: 'absolute',
                left: arrowX != null ? `${arrowX}px` : '',
                top: arrowY != null ? `${arrowY}px` : '',
                right: '',
                bottom: '',
            });

            if (staticSide) {
                arrowEl.style[staticSide] = '-5px';
            }
        }
    });
}

function mapContextMenuPlacement(side, align) {
    const a = align ?? 'start';
    const s = side ?? 'right';

    if (s === 'inline-end' || s === 'right') {
        if (a === 'end') {
            return 'right-end';
        }

        if (a === 'center') {
            return 'right';
        }

        return 'right-start';
    }

    if (s === 'inline-start' || s === 'left') {
        if (a === 'end') {
            return 'left-end';
        }

        if (a === 'center') {
            return 'left';
        }

        return 'left-start';
    }

    if (s === 'bottom') {
        if (a === 'end') {
            return 'bottom-end';
        }

        if (a === 'center') {
            return 'bottom';
        }

        return 'bottom-start';
    }

    if (s === 'top') {
        if (a === 'end') {
            return 'top-end';
        }

        if (a === 'center') {
            return 'top';
        }

        return 'top-start';
    }

    return 'right-start';
}

document.addEventListener('alpine:init', () => {
    const Alpine = window.Alpine;

    const initialStoredTheme = document.documentElement.getAttribute('data-theme') || 'system';
    const existingLayoutColorThemeStore = Alpine.store('layoutColorTheme');

    if (existingLayoutColorThemeStore) {
        existingLayoutColorThemeStore.stored = initialStoredTheme;
    } else {
        Alpine.store('layoutColorTheme', {
            stored: initialStoredTheme,
        });
    }

    Alpine.data('uiDialog', () => ({
        open: false,

        close() {
            this.open = false;
        },
    }));

    Alpine.data('uiTabs', (config) => {
        let defaultValue = null;
        let orientation = 'horizontal';

        if (config != null && typeof config === 'object' && !Array.isArray(config)) {
            defaultValue = config.defaultValue ?? config.default ?? null;
            orientation = config.orientation === 'vertical' ? 'vertical' : 'horizontal';
        } else {
            defaultValue = config;
        }

        return {
            active: defaultValue,
            orientation,

            init() {
                if (this.active === null || this.active === '') {
                    const first = this.$el.querySelector('[data-tab]');
                    this.active = first?.dataset.tab ?? '';
                }
            },

            select(value) {
                this.active = value;
            },

            focusSibling(delta) {
                const tabs = [...this.$el.querySelectorAll('[role="tab"]')];
                const i = tabs.indexOf(document.activeElement);

                if (i === -1) {
                    return;
                }

                const next = tabs[i + delta];
                next?.focus();
            },

            focusFromKeyboard(event) {
                const vertical = this.$el.dataset.orientation === 'vertical';

                if (vertical) {
                    if (event.key === 'ArrowDown') {
                        event.preventDefault();
                        this.focusSibling(1);
                    }
                    if (event.key === 'ArrowUp') {
                        event.preventDefault();
                        this.focusSibling(-1);
                    }
                } else {
                    if (event.key === 'ArrowRight') {
                        event.preventDefault();
                        this.focusSibling(1);
                    }
                    if (event.key === 'ArrowLeft') {
                        event.preventDefault();
                        this.focusSibling(-1);
                    }
                }
            },
        };
    });

    Alpine.data('uiPopover', (config = {}) => ({
        open: false,
        cleanup: null,
        side: config.side ?? 'bottom',
        align: config.align ?? 'center',
        placement: mapContextMenuPlacement(config.side ?? 'bottom', config.align ?? 'center'),
        alignOffset: Number(config.alignOffset ?? 0),
        sideOffset: Number(config.sideOffset ?? 4),

        toggle() {
            this.open = !this.open;
        },

        close() {
            this.open = false;
        },

        init() {
            this.$watch('open', async (value) => {
                if (value) {
                    await this.$nextTick();
                    const ref = this.$refs.reference;
                    const fl = this.$refs.floating;

                    if (ref && fl) {
                        this.cleanup = bindFloatingMenu(ref, fl, this.placement, {
                            mainAxis: this.sideOffset,
                            crossAxis: this.alignOffset,
                        });
                    }
                } else if (this.cleanup) {
                    this.cleanup();
                    this.cleanup = null;
                }
            });
        },
    }));

    Alpine.data('uiDropdownMenu', (config = {}) => ({
        open: false,
        cleanup: null,
        _dropdownMenuId: null,
        _onOutsidePointerDown: null,
        _onOtherDropdownOpened: null,
        placement: mapContextMenuPlacement(config.side ?? 'bottom', config.align ?? 'start'),
        alignOffset: Number(config.alignOffset ?? 0),
        sideOffset: Number(config.sideOffset ?? 4),
        focusFirstOnOpen: (() => {
            const v = config.focusFirstOnOpen;

            if (v === undefined || v === null) {
                return true;
            }

            return Boolean(v);
        })(),

        toggle() {
            this.open = !this.open;
        },

        close() {
            this.open = false;
        },

        _bindOutsidePointerDown() {
            if (this._onOutsidePointerDown) {
                return;
            }

            this._onOutsidePointerDown = (e) => {
                if (!this.open) {
                    return;
                }

                const ref = this.$refs.reference;
                const fl = this.$refs.floating;

                if (ref?.contains(e.target) || fl?.contains(e.target)) {
                    return;
                }

                this.close();
            };

            document.addEventListener('pointerdown', this._onOutsidePointerDown, true);
        },

        _unbindOutsidePointerDown() {
            if (!this._onOutsidePointerDown) {
                return;
            }

            document.removeEventListener('pointerdown', this._onOutsidePointerDown, true);
            this._onOutsidePointerDown = null;
        },

        init() {
            const uid =
                typeof crypto !== 'undefined' && typeof crypto.randomUUID === 'function'
                    ? crypto.randomUUID().replace(/-/g, '')
                    : `ddm${Date.now()}`;

            this._dropdownMenuId = `ui-ddm-${uid}`;

            this._onOtherDropdownOpened = (e) => {
                if (e.detail?.id !== this._dropdownMenuId) {
                    this.close();
                }
            };

            window.addEventListener('ui-dropdown-menu:request-open', this._onOtherDropdownOpened);

            this.$watch('open', async (value) => {
                if (value) {
                    window.dispatchEvent(
                        new CustomEvent('ui-dropdown-menu:request-open', {
                            bubbles: true,
                            detail: { id: this._dropdownMenuId },
                        }),
                    );

                    await this.$nextTick();
                    const ref = this.$refs.reference;
                    const fl = this.$refs.floating;

                    if (ref && fl) {
                        this.cleanup = bindFloatingMenu(ref, fl, this.placement, {
                            mainAxis: this.sideOffset,
                            crossAxis: this.alignOffset,
                        });
                    }

                    this._bindOutsidePointerDown();

                    await this.$nextTick();

                    if (this.focusFirstOnOpen) {
                        this.$refs.floating
                            ?.querySelector(
                                '[role="menuitem"]:not([disabled]):not([aria-disabled="true"]), [role="menuitemcheckbox"]:not([disabled]):not([aria-disabled="true"]), [role="menuitemradio"]:not([disabled]):not([aria-disabled="true"])',
                            )
                            ?.focus?.({ preventScroll: true });
                    }
                } else {
                    this._unbindOutsidePointerDown();

                    if (this.cleanup) {
                        this.cleanup();
                        this.cleanup = null;
                    }
                }
            });
        },

        destroy() {
            this._unbindOutsidePointerDown();

            if (this._onOtherDropdownOpened) {
                window.removeEventListener('ui-dropdown-menu:request-open', this._onOtherDropdownOpened);
                this._onOtherDropdownOpened = null;
            }

            if (this.cleanup) {
                this.cleanup();
                this.cleanup = null;
            }
        },
    }));

    Alpine.data('uiDropdownMenuSub', (config = {}) => ({
        open: false,
        cleanup: null,
        openTimer: null,
        closeTimer: null,
        placement: mapContextMenuPlacement(config.side ?? 'right', config.align ?? 'start'),
        alignOffset: Number(config.alignOffset ?? -3),
        sideOffset: Number(config.sideOffset ?? 0),

        cancelTimers() {
            clearTimeout(this.openTimer);
            clearTimeout(this.closeTimer);
            this.openTimer = null;
            this.closeTimer = null;
        },

        scheduleOpen() {
            this.cancelTimers();
            this.openTimer = setTimeout(() => {
                this.open = true;
            }, 60);
        },

        scheduleClose() {
            this.cancelTimers();
            this.closeTimer = setTimeout(() => {
                this.open = false;
            }, 200);
        },

        keepOpen() {
            this.cancelTimers();
        },

        init() {
            this.$watch('open', async (value) => {
                if (value) {
                    await this.$nextTick();
                    const ref = this.$refs.subTrigger;
                    const fl = this.$refs.subFloating;

                    if (ref && fl) {
                        this.cleanup = bindFloatingMenu(ref, fl, this.placement, {
                            mainAxis: this.sideOffset,
                            crossAxis: this.alignOffset,
                        });
                    }
                } else if (this.cleanup) {
                    this.cleanup();
                    this.cleanup = null;
                }
            });
        },
    }));

    Alpine.data('uiTooltip', (config = {}) => ({
        open: false,
        cleanup: null,
        showTimer: null,
        hideTimer: null,
        openDelayMs: 0,
        delayedState: false,
        placement: 'top',
        sideOffset: 4,
        alignOffset: 0,

        init() {
            const provider = this.$el.closest('[data-slot="tooltip-provider"]');
            let delay = config.delay;

            if (delay === null || delay === undefined) {
                if (provider) {
                    const raw = provider.getAttribute('data-tooltip-delay');
                    delay = raw !== null && raw !== '' ? parseInt(raw, 10) : 0;
                } else {
                    delay = 0;
                }
            } else {
                delay = Number(delay);
            }

            this.openDelayMs = Number.isFinite(delay) ? Math.max(0, delay) : 0;
            this.placement = mapContextMenuPlacement(config.side ?? 'top', config.align ?? 'center');
            this.sideOffset = Number(config.sideOffset ?? 4);
            this.alignOffset = Number(config.alignOffset ?? 0);
        },

        syncPlacementFromFloating() {
            const fl = this.$refs.floating;

            if (! fl?.dataset?.configSide) {
                return;
            }

            this.placement = mapContextMenuPlacement(fl.dataset.configSide, fl.dataset.configAlign || 'center');
            this.sideOffset = Number(fl.dataset.configSideOffset ?? 4);
            this.alignOffset = Number(fl.dataset.configAlignOffset ?? 0);
        },

        show() {
            this.cancelHide();
            clearTimeout(this.showTimer);
            this.showTimer = setTimeout(async () => {
                this.open = true;
                this.delayedState = this.openDelayMs > 0;
                await this.$nextTick();
                await this.$nextTick();
                const ref = this.$refs.reference;
                const fl = this.$refs.floating;
                const ar = this.$refs.tooltipArrow;

                if (ref && fl) {
                    this.syncPlacementFromFloating();
                    this.cleanup = bindFloatingTooltip(ref, fl, ar ?? null, this.placement, {
                        mainAxis: this.sideOffset,
                        crossAxis: this.alignOffset,
                    });
                }
            }, this.openDelayMs);
        },

        hide() {
            clearTimeout(this.showTimer);
            this.showTimer = null;
            this.hideTimer = setTimeout(() => {
                if (this.cleanup) {
                    this.cleanup();
                    this.cleanup = null;
                }

                this.open = false;
                this.delayedState = false;
            }, 80);
        },

        cancelHide() {
            clearTimeout(this.hideTimer);
            this.hideTimer = null;
        },
    }));

    Alpine.data('uiHoverCard', (config = {}) => ({
        open: false,
        cleanup: null,
        showTimer: null,
        hideTimer: null,
        placement: mapContextMenuPlacement(config.side ?? 'bottom', config.align ?? 'center'),
        alignOffset: Number(config.alignOffset ?? 4),
        sideOffset: Number(config.sideOffset ?? 4),

        show() {
            clearTimeout(this.hideTimer);
            this.showTimer = setTimeout(async () => {
                this.open = true;
                await this.$nextTick();
                const ref = this.$refs.reference;
                const fl = this.$refs.floating;

                if (ref && fl) {
                    this.cleanup = bindFloatingMenu(ref, fl, this.placement, {
                        mainAxis: this.sideOffset,
                        crossAxis: this.alignOffset,
                    });
                }
            }, 250);
        },

        hide() {
            clearTimeout(this.showTimer);
            this.hideTimer = setTimeout(() => {
                if (this.cleanup) {
                    this.cleanup();
                    this.cleanup = null;
                }

                this.open = false;
            }, 80);
        },

        cancelHide() {
            clearTimeout(this.hideTimer);
            this.hideTimer = null;
        },
    }));

    Alpine.data('uiSelect', (config) => ({
        /** Nome evita colisão com `window.open` em expressões Alpine (`x-show="open"` ficava truthy). */
        panelOpen: false,
        selectedValue:
            config.initialValue === undefined || config.initialValue === null || config.initialValue === ''
                ? ''
                : String(config.initialValue),
        placeholder: config.placeholder ?? 'Selecionar…',
        disabled: Boolean(config.disabled),
        invalid: Boolean(config.invalid),
        triggerId: config.triggerId ?? '',
        listboxId: config.listboxId ?? '',
        activeIndex: 0,
        options: [],
        displayLabel: '',
        scrollHoverTimer: null,
        canScrollUp: false,
        canScrollDown: false,
        scrollAffordanceObserver: null,
        affordanceOnResize: null,
        panelPositionCleanup: null,

        unbindPanelPosition() {
            if (this.panelPositionCleanup) {
                this.panelPositionCleanup();
                this.panelPositionCleanup = null;
            }

            const el = this.$refs.floatingPanel;

            if (el?.style) {
                ['left', 'top', 'position', 'width', 'maxWidth', 'maxHeight'].forEach((prop) => {
                    el.style.removeProperty(prop);
                });
            }
        },

        onSelectPointerDownOutside(e) {
            if (!this.panelOpen || this.disabled) {
                return;
            }

            const ref = this.$refs.reference;
            const panel = this.$refs.floatingPanel;

            if (ref?.contains(e.target) || panel?.contains(e.target)) {
                return;
            }

            this.close();
        },

        init() {
            this.$watch('selectedValue', () => {
                this.panelOpen = false;

                const hidden = this.$refs.hiddenInput;

                if (hidden) {
                    hidden.value = this.selectedValue === null || this.selectedValue === '' ? '' : String(this.selectedValue);
                    hidden.dispatchEvent(new Event('input', { bubbles: true }));
                    hidden.dispatchEvent(new Event('change', { bubbles: true }));
                }

                this.syncDisplayLabel();
                this.updateOptionAria();
            });

            this.$watch('panelOpen', async (value) => {
                if (value) {
                    await this.$nextTick();
                    this.refreshOptions();
                    this.setActiveToSelectedOrFirst();
                    this.updateHighlight();
                    this.updateOptionAria();

                    await this.$nextTick();
                    const refEl = this.$refs.reference;
                    const panelEl = this.$refs.floatingPanel;

                    if (refEl && panelEl) {
                        this.unbindPanelPosition();
                        this.panelPositionCleanup = bindFloatingSelectPanel(refEl, panelEl);
                    }

                    await this.$nextTick();
                    this.refreshOptions();
                    this.setActiveToSelectedOrFirst();
                    this.updateHighlight();
                    this.updateOptionAria();
                    this.$refs.viewport?.focus({ preventScroll: true });
                    this.bindScrollAffordanceObserver();
                    requestAnimationFrame(() => {
                        this.updateScrollAffordances();
                        requestAnimationFrame(() => this.updateScrollAffordances());
                    });
                } else {
                    this.unbindPanelPosition();

                    this.unbindScrollAffordanceObserver();
                    this.canScrollUp = false;
                    this.canScrollDown = false;
                    this.stopScrollHover();
                    this.clearActiveStyles();
                    this.$refs.reference?.focus({ preventScroll: true });
                }
            });

            this.$nextTick(() => {
                const hidden = this.$refs.hiddenInput;

                if (hidden && hidden.value !== '') {
                    this.selectedValue = hidden.value;
                }

                this.refreshOptions();
                this.syncDisplayLabel();
                this.updateOptionAria();
            });
        },

        refreshOptions() {
            const root = this.$refs.viewport;

            if (!root) {
                this.options = [];

                return;
            }

            this.options = [...root.querySelectorAll('[data-ui-select-option]')].map((el) => {
                const textEl = el.querySelector('[data-ui-select-option-text]');

                return {
                    value: el.dataset.value ?? '',
                    label: textEl?.textContent?.trim() ?? el.textContent?.trim() ?? '',
                    disabled: el.hasAttribute('data-disabled'),
                    el,
                    id: el.id || null,
                };
            });
        },

        syncDisplayLabel() {
            const strVal = this.selectedValue === null || this.selectedValue === '' ? null : String(this.selectedValue);
            const o = this.options.find((x) => String(x.value) === strVal && !x.disabled);
            this.displayLabel = o?.label || (strVal ? strVal : this.placeholder);
        },

        updateOptionAria() {
            this.options.forEach((o) => {
                o.el.setAttribute('aria-selected', String(o.value) === String(this.selectedValue) ? 'true' : 'false');
            });
        },

        setActiveToSelectedOrFirst() {
            let idx = this.options.findIndex((x) => String(x.value) === String(this.selectedValue) && !x.disabled);

            if (idx === -1) {
                idx = this.options.findIndex((x) => !x.disabled);
            }

            this.activeIndex = idx === -1 ? 0 : idx;
        },

        selectValue(value) {
            this.refreshOptions();
            const o = this.options.find((x) => String(x.value) === String(value) && !x.disabled);

            if (!o) {
                this.close();

                return;
            }

            // Fechar antes de atualizar o valor: `wire:model(.live)` no input oculto pode
            // disparar morph do Livewire no mesmo tick e interferir com o estado do painel.
            this.close();
            this.selectedValue = String(value);
        },

        selectFromEl(el) {
            if (!el || el.hasAttribute('data-disabled')) {
                return;
            }

            const v = el.dataset.value;

            if (v === undefined) {
                return;
            }

            this.selectValue(v);
            this.$nextTick(() => {
                this.panelOpen = false;
            });
        },

        setActiveFromEl(el) {
            if (!el || el.hasAttribute('data-disabled')) {
                return;
            }

            const idx = this.options.findIndex((o) => o.el === el);

            if (idx !== -1) {
                this.activeIndex = idx;
                this.updateHighlight();
            }
        },

        selectByIndex(i) {
            const o = this.options[i];

            if (!o || o.disabled) {
                return;
            }

            this.selectValue(o.value);
        },

        clearActiveStyles() {
            this.options.forEach((o) => {
                o.el.classList.remove('bg-accent', 'text-accent-foreground');
                o.el.removeAttribute('data-active');
            });
            this.$refs.viewport?.removeAttribute('aria-activedescendant');
        },

        updateHighlight() {
            this.clearActiveStyles();
            const o = this.options[this.activeIndex];

            if (!o || o.disabled) {
                return;
            }

            o.el.classList.add('bg-accent', 'text-accent-foreground');
            o.el.setAttribute('data-active', 'true');

            if (o.id) {
                this.$refs.viewport?.setAttribute('aria-activedescendant', o.id);
            }

            o.el.scrollIntoView({ block: 'nearest' });
            this.$nextTick(() => this.updateScrollAffordances());
        },

        isOptionSelected(value) {
            return String(this.selectedValue) === String(value);
        },

        scrollListBy(delta) {
            this.$refs.viewport?.scrollBy({ top: delta, behavior: 'smooth' });
            this.$nextTick(() => this.updateScrollAffordances());
        },

        updateScrollAffordances() {
            const el = this.$refs.viewport;

            if (!el) {
                this.canScrollUp = false;
                this.canScrollDown = false;

                return;
            }

            const { scrollTop, scrollHeight, clientHeight } = el;
            const eps = 2;
            this.canScrollUp = scrollTop > eps;
            this.canScrollDown = scrollTop + clientHeight < scrollHeight - eps;
        },

        bindScrollAffordanceObserver() {
            this.unbindScrollAffordanceObserver();
            const vp = this.$refs.viewport;

            if (vp && typeof ResizeObserver !== 'undefined') {
                this.scrollAffordanceObserver = new ResizeObserver(() => this.updateScrollAffordances());
                this.scrollAffordanceObserver.observe(vp);
            }

            this.affordanceOnResize = () => this.updateScrollAffordances();
            window.addEventListener('resize', this.affordanceOnResize, { passive: true });
        },

        unbindScrollAffordanceObserver() {
            if (this.scrollAffordanceObserver) {
                this.scrollAffordanceObserver.disconnect();
                this.scrollAffordanceObserver = null;
            }

            if (this.affordanceOnResize) {
                window.removeEventListener('resize', this.affordanceOnResize);
                this.affordanceOnResize = null;
            }
        },

        startScrollHover(direction) {
            this.stopScrollHover();
            const step = () => {
                const vp = this.$refs.viewport;

                if (!vp) {
                    return;
                }

                vp.scrollTop += direction * 6;
                this.updateScrollAffordances();

                if (direction < 0 && !this.canScrollUp) {
                    this.stopScrollHover();
                }

                if (direction > 0 && !this.canScrollDown) {
                    this.stopScrollHover();
                }
            };
            step();
            this.scrollHoverTimer = setInterval(step, 32);
        },

        stopScrollHover() {
            if (this.scrollHoverTimer !== null) {
                clearInterval(this.scrollHoverTimer);
                this.scrollHoverTimer = null;
            }
        },

        toggle() {
            if (this.disabled) {
                return;
            }

            this.panelOpen = !this.panelOpen;
        },

        close() {
            this.stopScrollHover();
            this.panelOpen = false;
        },

        ensureEnabledIndex(dir) {
            const len = this.options.length;

            if (len === 0 || !this.options.some((o) => !o.disabled)) {
                return;
            }

            let i = this.activeIndex;

            for (let c = 0; c < len; c++) {
                i = (i + dir + len) % len;

                if (!this.options[i].disabled) {
                    this.activeIndex = i;

                    return;
                }
            }
        },

        onKeydown(e) {
            if (this.disabled) {
                return;
            }

            if (!this.panelOpen && (e.key === 'ArrowDown' || e.key === 'ArrowUp' || e.key === ' ' || e.key === 'Enter')) {
                e.preventDefault();
                this.panelOpen = true;

                return;
            }

            if (this.panelOpen && (e.key === 'ArrowDown' || e.key === 'ArrowUp')) {
                e.preventDefault();
                this.ensureEnabledIndex(e.key === 'ArrowDown' ? 1 : -1);
                this.updateHighlight();

                return;
            }

            if (e.key === 'Escape' && this.panelOpen) {
                e.preventDefault();
                this.close();
            }
        },

        onListboxKeydown(e) {
            if (!this.panelOpen) {
                return;
            }

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                this.ensureEnabledIndex(1);
                this.updateHighlight();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                this.ensureEnabledIndex(-1);
                this.updateHighlight();
            } else if (e.key === 'Home') {
                e.preventDefault();
                const idx = this.options.findIndex((o) => !o.disabled);

                if (idx !== -1) {
                    this.activeIndex = idx;
                    this.updateHighlight();
                }
            } else if (e.key === 'End') {
                e.preventDefault();
                let idx = -1;

                for (let i = this.options.length - 1; i >= 0; i--) {
                    if (!this.options[i].disabled) {
                        idx = i;
                        break;
                    }
                }

                if (idx !== -1) {
                    this.activeIndex = idx;
                    this.updateHighlight();
                }
            } else if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.selectByIndex(this.activeIndex);
            } else if (e.key === 'Escape') {
                e.preventDefault();
                this.close();
            }
        },

        destroy() {
            this.unbindPanelPosition();
            this.unbindScrollAffordanceObserver();
            this.stopScrollHover();
        },
    }));

    Alpine.data('uiCombobox', (options) => ({
        open: false,
        query: '',
        selectedValue: '',
        activeIndex: -1,
        items: [],
        filtered: [],
        inputId: '',
        listId: '',
        disabled: Boolean(options?.disabled),

        init() {
            const raw = options?.items ?? [];

            this.items = raw.map((x) => {
                if (typeof x === 'string' || typeof x === 'number') {
                    const s = String(x);

                    return { value: s, label: s };
                }

                return {
                    value: String(x.value ?? x.label ?? ''),
                    label: String(x.label ?? x.value ?? ''),
                };
            });

            this.filtered = [...this.items];

            const initialRaw = options?.initialValue;
            const initial =
                initialRaw === undefined || initialRaw === null || initialRaw === '' ? '' : String(initialRaw);

            if (initial !== '') {
                this.selectedValue = initial;
                const match = this.items.find((i) => i.value === initial);

                this.query = match ? match.label : '';
            }

            this.$watch('selectedValue', () => {
                const hidden = this.$refs.hiddenInput;

                if (hidden) {
                    hidden.value =
                        this.selectedValue === null || this.selectedValue === '' ? '' : String(this.selectedValue);
                    hidden.dispatchEvent(new Event('input', { bubbles: true }));
                    hidden.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });

            const uid =
                typeof crypto !== 'undefined' && typeof crypto.randomUUID === 'function'
                    ? crypto.randomUUID().replace(/-/g, '')
                    : `cb${Date.now()}`;

            this.inputId = `cb-${uid}-input`;
            this.listId = `cb-${uid}-list`;

            this._onUiComboboxRequestOpen = (e) => {
                if (e.detail?.id !== this.inputId) {
                    this.close();
                }
            };
            window.addEventListener('ui-combobox:request-open', this._onUiComboboxRequestOpen);

            // Fecha ao interagir fora (captura: funciona bem em células PowerGrid, mousedown na lista, etc.)
            this._onDocumentPointerDown = (e) => {
                if (!this.open || this.disabled) {
                    return;
                }

                if (this.$el.contains(e.target)) {
                    return;
                }

                this.close();
            };
            document.addEventListener('pointerdown', this._onDocumentPointerDown, true);

            this.$watch('open', (value) => {
                if (value) {
                    window.dispatchEvent(
                        new CustomEvent('ui-combobox:request-open', {
                            bubbles: true,
                            detail: { id: this.inputId },
                        }),
                    );
                }
            });

            this.$watch('query', () => {
                const q = this.query.toLowerCase();

                this.filtered = this.items.filter((item) => item.label.toLowerCase().includes(q));
                this.activeIndex = this.filtered.length ? 0 : -1;
            });

            this.$nextTick(() => {
                const hidden = this.$refs.hiddenInput;

                if (!hidden) {
                    return;
                }

                if (hidden.value !== '') {
                    this.selectedValue = hidden.value;
                    const m = this.items.find((i) => i.value === this.selectedValue);

                    this.query = m ? m.label : '';

                    return;
                }

                if (this.selectedValue !== '') {
                    hidden.value = String(this.selectedValue);
                    hidden.dispatchEvent(new Event('input', { bubbles: true }));
                    hidden.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        },

        toggle() {
            if (this.disabled) {
                return;
            }

            this.open = !this.open;

            if (this.open) {
                this.$nextTick(() => {
                    this.$refs.input?.focus();
                });
            }
        },

        close() {
            this.open = false;
        },

        clear() {
            if (this.disabled) {
                return;
            }

            this.query = '';
            this.selectedValue = '';
            this.filtered = [...this.items];
            this.activeIndex = this.filtered.length ? 0 : -1;
            this.$nextTick(() => {
                this.$refs.input?.focus();
            });
        },

        selectIndex(i) {
            const item = this.filtered[i];

            if (item !== undefined) {
                this.query = item.label;
                this.selectedValue = item.value;
            }

            this.close();
        },

        onKeydown(e) {
            if (this.disabled) {
                return;
            }

            if (e.key === 'Escape') {
                e.preventDefault();
                this.close();

                return;
            }

            if (e.key === 'ArrowDown') {
                e.preventDefault();

                if (!this.open) {
                    this.open = true;
                    this.activeIndex = this.filtered.length ? 0 : -1;
                } else {
                    this.activeIndex = Math.min(this.filtered.length - 1, this.activeIndex + 1);
                }

                return;
            }

            if (e.key === 'ArrowUp') {
                e.preventDefault();

                if (!this.open) {
                    this.open = true;
                }

                this.activeIndex = Math.max(0, this.activeIndex - 1);

                return;
            }

            if (e.key === 'Enter') {
                if (this.open && this.activeIndex >= 0) {
                    e.preventDefault();
                    this.selectIndex(this.activeIndex);
                }

                return;
            }
        },

        destroy() {
            if (this._onUiComboboxRequestOpen) {
                window.removeEventListener('ui-combobox:request-open', this._onUiComboboxRequestOpen);
            }

            if (this._onDocumentPointerDown) {
                document.removeEventListener('pointerdown', this._onDocumentPointerDown, true);
            }
        },
    }));

    Alpine.data('uiCalendar', (config = {}) => ({
        mode: config.mode === 'range' ? 'range' : 'single',
        showOutsideDays: config.showOutsideDays !== false,
        locale: config.locale ?? 'pt-PT',
        weekStartsOn: Number(config.weekStartsOn) === 0 ? 0 : 1,
        min: config.min ? new Date(String(config.min) + 'T12:00:00') : null,
        max: config.max ? new Date(String(config.max) + 'T12:00:00') : null,
        viewYear: null,
        viewMonth: null,
        selected: null,
        rangeFrom: null,
        rangeTo: null,
        selectedIso: '',
        rangeFromIso: '',
        rangeToIso: '',

        init() {
            const today = new Date();
            today.setHours(12, 0, 0, 0);

            if (config.defaultMonth) {
                const d = new Date(String(config.defaultMonth) + 'T12:00:00');

                if (!Number.isNaN(d.getTime())) {
                    this.viewYear = d.getFullYear();
                    this.viewMonth = d.getMonth();
                }
            }

            if (this.viewYear === null) {
                this.viewYear = today.getFullYear();
                this.viewMonth = today.getMonth();
            }

            if (config.initialSelected) {
                const d = new Date(String(config.initialSelected) + 'T12:00:00');

                if (!Number.isNaN(d.getTime())) {
                    this.selected = d;
                    this.viewYear = d.getFullYear();
                    this.viewMonth = d.getMonth();
                }
            }

            if (this.mode === 'range') {
                if (config.initialFrom) {
                    const a = new Date(String(config.initialFrom) + 'T12:00:00');

                    if (!Number.isNaN(a.getTime())) {
                        this.rangeFrom = a;
                    }
                }

                if (config.initialTo) {
                    const b = new Date(String(config.initialTo) + 'T12:00:00');

                    if (!Number.isNaN(b.getTime())) {
                        this.rangeTo = b;
                    }
                }
            }

            this.hydrateIsoFields();
        },

        toIso(d) {
            if (!d) {
                return '';
            }

            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');

            return `${y}-${m}-${day}`;
        },

        sameDay(a, b) {
            return Boolean(a && b && this.toIso(a) === this.toIso(b));
        },

        atNoon(d) {
            const x = new Date(d);

            x.setHours(12, 0, 0, 0);

            return x;
        },

        time(d) {
            return this.atNoon(d).getTime();
        },

        isDisabled(date) {
            const t = this.time(date);

            if (this.min && t < this.time(this.min)) {
                return true;
            }

            if (this.max && t > this.time(this.max)) {
                return true;
            }

            return false;
        },

        sortedRange() {
            if (!this.rangeFrom || !this.rangeTo) {
                return { start: this.rangeFrom, end: this.rangeTo };
            }

            const a = this.time(this.rangeFrom);
            const b = this.time(this.rangeTo);

            return a <= b
                ? { start: this.rangeFrom, end: this.rangeTo }
                : { start: this.rangeTo, end: this.rangeFrom };
        },

        isRangeStart(d) {
            if (this.mode !== 'range') {
                return false;
            }

            const { start } = this.sortedRange();

            return Boolean(start && this.sameDay(d, start));
        },

        isRangeEnd(d) {
            if (this.mode !== 'range') {
                return false;
            }

            const { end } = this.sortedRange();

            return Boolean(end && this.sameDay(d, end));
        },

        isRangeMiddle(d) {
            if (this.mode !== 'range') {
                return false;
            }

            const { start, end } = this.sortedRange();

            if (!start || !end) {
                return false;
            }

            const t = this.time(d);
            const lo = this.time(start);
            const hi = this.time(end);

            return t > lo && t < hi;
        },

        isToday(d) {
            const t = new Date();
            t.setHours(12, 0, 0, 0);

            return this.sameDay(d, t);
        },

        isSelectedSingle(d) {
            return this.mode === 'single' && Boolean(this.selected && this.sameDay(d, this.selected));
        },

        monthCaption() {
            return new Date(this.viewYear, this.viewMonth, 1).toLocaleString(this.locale, {
                month: 'long',
                year: 'numeric',
            });
        },

        weekdayLabels() {
            const fmt = new Intl.DateTimeFormat(this.locale, { weekday: 'short' });
            const ref = new Date(2024, 5, 2 + this.weekStartsOn);
            const labels = [];

            for (let i = 0; i < 7; i++) {
                const dt = new Date(ref);

                dt.setDate(ref.getDate() + i);
                labels.push(fmt.format(dt));
            }

            return labels;
        },

        buildWeeks() {
            const y = this.viewYear;
            const m = this.viewMonth;
            const firstOfMonth = new Date(y, m, 1);

            firstOfMonth.setHours(12, 0, 0, 0);

            const firstDow = firstOfMonth.getDay();
            const offset = (firstDow - this.weekStartsOn + 7) % 7;
            const cur = new Date(y, m, 1 - offset);

            cur.setHours(12, 0, 0, 0);

            const rows = [];

            for (let w = 0; w < 6; w++) {
                const row = [];

                for (let d = 0; d < 7; d++) {
                    const inMonth = cur.getMonth() === m;
                    const hide = !inMonth && !this.showOutsideDays;

                    row.push({
                        date: new Date(cur),
                        inMonth,
                        hide,
                        dayNum: cur.getDate(),
                        key: this.toIso(cur),
                    });
                    cur.setDate(cur.getDate() + 1);
                }

                rows.push(row);
            }

            return rows;
        },

        prevMonth() {
            if (this.viewMonth === 0) {
                this.viewMonth = 11;
                this.viewYear -= 1;
            } else {
                this.viewMonth -= 1;
            }
        },

        nextMonth() {
            if (this.viewMonth === 11) {
                this.viewMonth = 0;
                this.viewYear += 1;
            } else {
                this.viewMonth += 1;
            }
        },

        selectDay(cell) {
            if (cell.hide || this.isDisabled(cell.date)) {
                return;
            }

            const picked = new Date(cell.date);

            picked.setHours(12, 0, 0, 0);

            if (this.mode === 'single') {
                this.selected = picked;
                this.hydrateIsoFields();
                this.emitSelect();

                return;
            }

            if (!this.rangeFrom || (this.rangeFrom && this.rangeTo)) {
                this.rangeFrom = picked;
                this.rangeTo = null;
            } else {
                let end = picked;
                let start = new Date(this.rangeFrom);

                if (this.time(end) < this.time(start)) {
                    [start, end] = [end, start];
                }

                this.rangeFrom = start;
                this.rangeTo = end;
            }

            this.hydrateIsoFields();
            this.emitSelect();
        },

        hydrateIsoFields() {
            if (this.mode === 'single') {
                this.selectedIso = this.selected ? this.toIso(this.selected) : '';
                this.rangeFromIso = '';
                this.rangeToIso = '';
            } else {
                this.selectedIso = '';
                const { start, end } = this.sortedRange();

                this.rangeFromIso = start ? this.toIso(start) : '';
                this.rangeToIso = end ? this.toIso(end) : '';
            }
        },

        emitSelect() {
            this.$dispatch('calendar-select', {
                mode: this.mode,
                value: this.selectedIso,
                from: this.rangeFromIso,
                to: this.rangeToIso,
            });
        },

        dayTdClass(cell) {
            const parts = [
                'group/day relative aspect-square h-full w-full rounded-(--cell-radius) p-0 text-center select-none',
            ];

            if (cell.hide) {
                parts.push('invisible');
            }

            if (this.isSelectedSingle(cell.date)) {
                parts.push('[&:last-child[data-selected-single=true]_button]:rounded-r-(--cell-radius)');
            }

            if (this.isRangeStart(cell.date)) {
                parts.push(
                    'relative isolate z-0 rounded-l-(--cell-radius) bg-muted after:absolute after:inset-y-0 after:right-0 after:w-4 after:bg-muted',
                );
            }

            if (this.isRangeMiddle(cell.date)) {
                parts.push('rounded-none');
            }

            if (this.isRangeEnd(cell.date)) {
                parts.push(
                    'relative isolate z-0 rounded-r-(--cell-radius) bg-muted after:absolute after:inset-y-0 after:left-0 after:w-4 after:bg-muted',
                );
            }

            if (this.isToday(cell.date)) {
                parts.push(
                    'rounded-(--cell-radius) bg-muted text-foreground data-[selected-single=true]:rounded-none',
                );
            }

            if (!cell.inMonth) {
                parts.push('text-muted-foreground aria-selected:text-muted-foreground');
            }

            if (this.isDisabled(cell.date)) {
                parts.push('text-muted-foreground opacity-50');
            }

            return parts.join(' ');
        },

        dayButtonClass() {
            return [
                'relative isolate z-10 flex aspect-square size-auto w-full min-w-(--cell-size) flex-col gap-1 border-0 leading-none font-normal',
                'group-data-[focused=true]/day:relative group-data-[focused=true]/day:z-10 group-data-[focused=true]/day:border-ring group-data-[focused=true]/day:ring-[3px] group-data-[focused=true]/day:ring-ring/50',
                'data-[range-end=true]:rounded-(--cell-radius) data-[range-end=true]:rounded-r-(--cell-radius) data-[range-end=true]:bg-primary data-[range-end=true]:text-primary-foreground',
                'data-[range-middle=true]:rounded-none data-[range-middle=true]:bg-muted data-[range-middle=true]:text-foreground',
                'data-[range-start=true]:rounded-(--cell-radius) data-[range-start=true]:rounded-l-(--cell-radius) data-[range-start=true]:bg-primary data-[range-start=true]:text-primary-foreground',
                'data-[selected-single=true]:bg-primary data-[selected-single=true]:text-primary-foreground dark:hover:text-foreground [&>span]:text-xs [&>span]:opacity-70',
            ].join(' ');
        },
    }));

    Alpine.data('uiCarousel', (config = {}) => ({
        embla: null,
        canScrollPrev: false,
        canScrollNext: false,
        orientation: config.orientation === 'vertical' ? 'vertical' : 'horizontal',

        init() {
            this.$nextTick(() => {
                this.mountEmbla();
            });
        },

        mountEmbla() {
            const viewport = this.$refs.viewport;

            if (!viewport) {
                return;
            }

            const opts = {
                ...(config.opts ?? {}),
                axis: this.orientation === 'vertical' ? 'y' : 'x',
            };

            this.embla = EmblaCarousel(viewport, opts);

            const onSelect = () => {
                this.syncScrollState();
            };

            this.embla.on('select', onSelect);
            this.embla.on('reInit', onSelect);
            this.syncScrollState();

            this.$dispatch('carousel-init', { api: this.embla });
        },

        syncScrollState() {
            if (!this.embla) {
                return;
            }

            this.canScrollPrev = this.embla.canScrollPrev();
            this.canScrollNext = this.embla.canScrollNext();
        },

        scrollPrev() {
            this.embla?.scrollPrev();
        },

        scrollNext() {
            this.embla?.scrollNext();
        },

        onKeydown(e) {
            if (this.orientation === 'horizontal') {
                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    this.scrollPrev();
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    this.scrollNext();
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                this.scrollPrev();
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                this.scrollNext();
            }
        },
    }));

    Alpine.data('uiCommand', (config = {}) => ({
        search: '',
        activeIndex: 0,
        rawGroups: Array.isArray(config.groups) ? config.groups : [],

        init() {
            this.$watch('search', () => {
                this.activeIndex = 0;
            });
        },

        get allItems() {
            const out = [];

            this.rawGroups.forEach((g) => {
                const heading = g?.heading ?? null;
                const items = Array.isArray(g?.items) ? g.items : [];

                items.forEach((raw) => {
                    const label = String(raw?.label ?? raw?.value ?? '');
                    const value = String(raw?.value ?? label);
                    const keywords = String(raw?.keywords ?? label).toLowerCase();

                    out.push({
                        label,
                        value,
                        keywords,
                        shortcut: raw?.shortcut ? String(raw.shortcut) : '',
                        disabled: Boolean(raw?.disabled),
                        heading,
                    });
                });
            });

            return out;
        },

        get filtered() {
            const q = this.search.toLowerCase().trim();

            return this.allItems
                .filter((item) => {
                    if (item.disabled) {
                        return false;
                    }

                    if (!q) {
                        return true;
                    }

                    return item.label.toLowerCase().includes(q) || item.keywords.includes(q);
                })
                .map((item, index) => ({ ...item, _flatIndex: index }));
        },

        get groupedFiltered() {
            const map = new Map();
            const order = [];

            this.filtered.forEach((item) => {
                const key = item.heading === null || item.heading === '' ? '__none__' : String(item.heading);

                if (!map.has(key)) {
                    map.set(key, { heading: item.heading, items: [] });
                    order.push(key);
                }

                map.get(key).items.push(item);
            });

            return order.map((k) => map.get(k));
        },

        onKeydown(e) {
            const list = this.filtered;

            if (list.length === 0) {
                return;
            }

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                this.activeIndex = (this.activeIndex + 1) % list.length;
                this.scrollActiveIntoView();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                this.activeIndex = (this.activeIndex - 1 + list.length) % list.length;
                this.scrollActiveIntoView();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                const item = list[this.activeIndex];

                if (item) {
                    this.selectItem(item);
                }
            }
        },

        selectItem(item) {
            this.$dispatch('command-select', { value: item.value, label: item.label });
        },

        scrollActiveIntoView() {
            this.$nextTick(() => {
                this.$el
                    .querySelector('[data-slot="command-item"][data-selected="true"]')
                    ?.scrollIntoView({ block: 'nearest' });
            });
        },
    }));

    Alpine.data('uiCommandDialog', () => ({
        open: false,

        close() {
            this.open = false;
        },

        toggle() {
            this.open = !this.open;
        },

        init() {
            this.$watch('open', async (value) => {
                if (!value) {
                    return;
                }

                await this.$nextTick();
                const root = this.$refs.dialogContent;
                root?.querySelector('[data-slot="command-input"]')?.focus();
            });
        },
    }));

    Alpine.data('uiContextMenu', (config = {}) => ({
        open: false,
        clientX: 0,
        clientY: 0,
        cleanup: null,
        placement: mapContextMenuPlacement(config.side, config.align),
        alignOffset: Number(config.alignOffset ?? 4),
        sideOffset: Number(config.sideOffset ?? 0),

        openAt(e) {
            e.preventDefault();
            e.stopPropagation();
            this.clientX = e.clientX;
            this.clientY = e.clientY;
            this.open = true;
        },

        close() {
            this.open = false;
        },

        outerContextMenu(e) {
            if (!this.open || !this.$refs.floating) {
                return;
            }

            if (this.$refs.floating.contains(e.target)) {
                return;
            }

            this.close();
        },

        handleFloatingClick(e) {
            if (!this.open) {
                return;
            }

            const el = e.target.closest('[data-context-menu-autoclose]');

            if (!el) {
                return;
            }

            if (el.disabled === true || el.getAttribute('aria-disabled') === 'true') {
                return;
            }

            this.close();
        },

        init() {
            this.$watch('open', async (value) => {
                if (value) {
                    await this.$nextTick();
                    const fl = this.$refs.floating;

                    if (!fl) {
                        return;
                    }

                    const offsetOpts = {
                        mainAxis: this.sideOffset,
                        crossAxis: this.alignOffset,
                    };

                    const virtualRef = {
                        getBoundingClientRect: () => ({
                            width: 0,
                            height: 0,
                            x: this.clientX,
                            y: this.clientY,
                            top: this.clientY,
                            left: this.clientX,
                            right: this.clientX,
                            bottom: this.clientY,
                        }),
                    };

                    this.cleanup = bindFloatingMenu(virtualRef, fl, this.placement, offsetOpts);

                    await this.$nextTick();

                    const focusable = fl.querySelector(
                        '[role="menuitem"]:not([disabled]):not([aria-disabled="true"]), [role="menuitemcheckbox"]:not([disabled]):not([aria-disabled="true"]), [role="menuitemradio"]:not([disabled]):not([aria-disabled="true"])',
                    );

                    focusable?.focus?.({ preventScroll: true });
                } else if (this.cleanup) {
                    this.cleanup();
                    this.cleanup = null;
                }
            });
        },
    }));

    Alpine.data('uiContextMenuSub', () => ({
        open: false,
        cleanup: null,
        openTimer: null,
        closeTimer: null,

        cancelTimers() {
            clearTimeout(this.openTimer);
            clearTimeout(this.closeTimer);
            this.openTimer = null;
            this.closeTimer = null;
        },

        scheduleOpen() {
            this.cancelTimers();
            this.openTimer = setTimeout(() => {
                this.open = true;
            }, 60);
        },

        scheduleClose() {
            this.cancelTimers();
            this.closeTimer = setTimeout(() => {
                this.open = false;
            }, 200);
        },

        keepOpen() {
            this.cancelTimers();
        },

        init() {
            this.$watch('open', async (value) => {
                if (value) {
                    await this.$nextTick();
                    const ref = this.$refs.subTrigger;
                    const fl = this.$refs.subFloating;

                    if (ref && fl) {
                        this.cleanup = bindFloatingMenu(ref, fl, 'right-start', { mainAxis: 4, crossAxis: 0 });
                    }
                } else if (this.cleanup) {
                    this.cleanup();
                    this.cleanup = null;
                }
            });
        },
    }));

    Alpine.data('uiNavigationMenu', (config = {}) => ({
        openId: null,
        cleanup: null,
        viewport: config.viewport !== false,
        align: config.align ?? 'start',
        triggerOnHover: config.triggerOnHover === true,
        hoverCloseTimer: null,
        panels: {},
        _triggerEl: null,

        registerPanel(id, el) {
            if (!id || !el) {
                return;
            }

            this.panels[id] = el;
        },

        cancelHoverClose() {
            if (this.hoverCloseTimer) {
                clearTimeout(this.hoverCloseTimer);
                this.hoverCloseTimer = null;
            }
        },

        scheduleHoverClose() {
            if (!this.triggerOnHover) {
                return;
            }

            this.cancelHoverClose();
            this.hoverCloseTimer = setTimeout(() => {
                this.hoverCloseTimer = null;
                this.close();
            }, 180);
        },

        open(id, triggerEl) {
            if (!id || !triggerEl) {
                return;
            }

            this.openId = id;
            this._triggerEl = triggerEl;
            this.$nextTick(() => this.position());
        },

        openFromHover(id, triggerEl) {
            if (!this.triggerOnHover || !id || !triggerEl) {
                return;
            }

            this.cancelHoverClose();

            if (this.openId !== id) {
                this.open(id, triggerEl);
            }
        },

        toggle(id, triggerEl) {
            this.cancelHoverClose();

            if (this.openId === id) {
                this.close();

                return;
            }

            this.open(id, triggerEl);
        },

        position() {
            if (this.cleanup) {
                this.cleanup();
                this.cleanup = null;
            }

            const panel = this.openId ? this.panels[this.openId] : null;
            const trigger = this._triggerEl;

            if (!panel || !trigger) {
                return;
            }

            ['position', 'left', 'top', 'right', 'bottom', 'zIndex', 'marginTop'].forEach((prop) => {
                panel.style[prop] = '';
            });

            if (!this.viewport) {
                panel.style.position = 'absolute';
                panel.style.left = '0';
                panel.style.top = '100%';
                panel.style.zIndex = '50';
                panel.style.marginTop = '8px';

                return;
            }

            this.cleanup = bindFloatingMenu(
                trigger,
                panel,
                mapContextMenuPlacement('bottom', this.align),
                { mainAxis: 8, crossAxis: 0 },
            );
        },

        close() {
            this.cancelHoverClose();
            this.openId = null;
            this._triggerEl = null;

            if (this.cleanup) {
                this.cleanup();
                this.cleanup = null;
            }
        },

        init() {
            this._onDocClick = (e) => {
                if (this.$el.contains(e.target)) {
                    return;
                }

                const panel = this.openId ? this.panels[this.openId] : null;

                if (panel && panel.contains(e.target)) {
                    return;
                }

                this.close();
            };

            document.addEventListener('click', this._onDocClick);

            this._onKey = (e) => {
                if (e.key === 'Escape') {
                    this.close();
                }
            };

            document.addEventListener('keydown', this._onKey);
        },

        destroy() {
            this.cancelHoverClose();

            if (this.cleanup) {
                this.cleanup();
                this.cleanup = null;
            }

            this.openId = null;
            this._triggerEl = null;

            if (this._onDocClick) {
                document.removeEventListener('click', this._onDocClick);
            }

            if (this._onKey) {
                document.removeEventListener('keydown', this._onKey);
            }
        },
    }));

    Alpine.data('uiInputOtp', (config = {}) => ({
        length: Math.max(1, Number(config.length ?? 6)),
        value: String(config.initialValue ?? '')
            .replace(/\D/g, '')
            .slice(0, Math.max(1, Number(config.length ?? 6))),
        focused: false,
        disabled: Boolean(config.disabled),

        slotChar(i) {
            return this.value[i] ?? '';
        },

        isActive(i) {
            if (!this.focused || this.disabled) {
                return false;
            }

            return i === Math.min(this.value.length, this.length - 1);
        },

        hasFakeCaret(i) {
            if (!this.focused || this.disabled) {
                return false;
            }

            return i === this.value.length && this.value.length < this.length;
        },

        setValueFromEvent(event) {
            if (this.disabled) {
                return;
            }

            const next = String(event.target.value)
                .replace(/\D/g, '')
                .slice(0, this.length);
            this.value = next;
            event.target.value = next;
        },

        focusOtp() {
            if (this.disabled) {
                return;
            }

            this.$refs.otpInput?.focus();
        },
    }));

    const SIDEBAR_COOKIE_NAME = 'sidebar_state';
    const SIDEBAR_COOKIE_MAX_AGE = 60 * 60 * 24 * 7;

    Alpine.data('uiSidebar', (config = {}) => ({
        open: config.defaultOpen !== undefined ? Boolean(config.defaultOpen) : true,
        openMobile: false,
        isMobile: false,
        mq: null,
        mqHandler: null,
        boundKbd: null,

        init() {
            this.mq = window.matchMedia('(max-width: 767px)');
            this.isMobile = this.mq.matches;
            this.mqHandler = (event) => {
                this.isMobile = event.matches;
                if (!this.isMobile) {
                    this.openMobile = false;
                }
            };
            this.mq.addEventListener('change', this.mqHandler);

            this.boundKbd = (event) => {
                if (event.key === 'b' && (event.metaKey || event.ctrlKey)) {
                    event.preventDefault();
                    this.toggleSidebar();
                }
            };
            window.addEventListener('keydown', this.boundKbd);
        },

        destroy() {
            if (this.mq && this.mqHandler) {
                this.mq.removeEventListener('change', this.mqHandler);
            }
            if (this.boundKbd) {
                window.removeEventListener('keydown', this.boundKbd);
            }
        },

        persistOpen() {
            document.cookie = `${SIDEBAR_COOKIE_NAME}=${this.open}; path=/; max-age=${SIDEBAR_COOKIE_MAX_AGE}`;
        },

        toggleSidebar() {
            if (this.isMobile) {
                this.openMobile = !this.openMobile;
            } else {
                this.open = !this.open;
                this.persistOpen();
            }
        },

        closeMobile() {
            this.openMobile = false;
        },
    }));

    Alpine.data('uiSlider', (config = {}) => ({
        values: Array.isArray(config.values) ? [...config.values] : [0],
        min: Number(config.min ?? 0),
        max: Number(config.max ?? 100),
        step: config.step != null && config.step !== '' ? Number(config.step) : null,
        disabled: Boolean(config.disabled),
        orientation: config.orientation === 'vertical' ? 'vertical' : 'horizontal',
        dragging: null,
        boundMove: null,
        boundUp: null,

        init() {
            this.boundMove = (e) => this.onPointerMove(e);
            this.boundUp = () => this.onPointerEnd();
            this.clampAll();
        },

        destroy() {
            this.onPointerEnd();
        },

        clampValue(v) {
            let n = Number(v);
            if (Number.isNaN(n)) {
                n = this.min;
            }
            n = Math.max(this.min, Math.min(this.max, n));
            if (this.step && this.step > 0) {
                const steps = Math.round((n - this.min) / this.step);
                n = this.min + steps * this.step;
                n = Math.max(this.min, Math.min(this.max, n));
            }
            return n;
        },

        clampAll() {
            this.values = this.values.map((v) => this.clampValue(v));
            if (this.values.length === 2 && this.values[0] > this.values[1]) {
                this.values = [this.values[1], this.values[0]];
            }
        },

        percent(i) {
            if (this.max === this.min) {
                return 0;
            }
            return ((this.values[i] - this.min) / (this.max - this.min)) * 100;
        },

        horizontalRangeStyle() {
            if (this.values.length < 2) {
                return { width: `${this.percent(0)}%` };
            }
            const p0 = this.percent(0);
            const p1 = this.percent(1);
            const left = Math.min(p0, p1);
            const width = Math.abs(p1 - p0);
            return { left: `${left}%`, width: `${width}%` };
        },

        verticalRangeStyle() {
            if (this.values.length < 2) {
                return { height: `${this.percent(0)}%` };
            }
            const p0 = this.percent(0);
            const p1 = this.percent(1);
            const bottom = Math.min(p0, p1);
            const height = Math.abs(p1 - p0);
            return { bottom: `${bottom}%`, height: `${height}%` };
        },

        thumbHorizontalStyle(i) {
            return { left: `${this.percent(i)}%`, top: '50%' };
        },

        thumbVerticalStyle(i) {
            return { bottom: `${this.percent(i)}%`, left: '50%' };
        },

        onThumbPointerDown(index, event) {
            if (this.disabled) {
                return;
            }
            event.preventDefault();
            event.stopPropagation();
            this.dragging = index;
            if (event.pointerId != null && event.currentTarget?.setPointerCapture) {
                event.currentTarget.setPointerCapture(event.pointerId);
            }
            window.addEventListener('pointermove', this.boundMove, { passive: false });
            window.addEventListener('pointerup', this.boundUp);
            window.addEventListener('pointercancel', this.boundUp);
        },

        onTrackPointerDown(event) {
            if (this.disabled) {
                return;
            }
            if (event.target?.closest?.('[data-slot=slider-thumb]')) {
                return;
            }
            event.preventDefault();
            const index = this.nearestThumbIndex(event);
            this.dragging = index;
            this.onPointerMove(event);
            window.addEventListener('pointermove', this.boundMove, { passive: false });
            window.addEventListener('pointerup', this.boundUp);
            window.addEventListener('pointercancel', this.boundUp);
        },

        nearestThumbIndex(event) {
            const track = this.$refs.track;
            if (!track) {
                return 0;
            }
            const rect = track.getBoundingClientRect();
            let pct;
            if (this.orientation === 'vertical') {
                pct = 1 - (event.clientY - rect.top) / rect.height;
            } else {
                pct = (event.clientX - rect.left) / rect.width;
            }
            pct = Math.max(0, Math.min(1, pct));
            const v = this.min + pct * (this.max - this.min);
            if (this.values.length === 1) {
                return 0;
            }
            const d0 = Math.abs(v - this.values[0]);
            const d1 = Math.abs(v - this.values[1]);
            return d0 <= d1 ? 0 : 1;
        },

        onPointerMove(event) {
            if (this.dragging === null) {
                return;
            }
            const track = this.$refs.track;
            if (!track) {
                return;
            }
            const rect = track.getBoundingClientRect();
            let pct;
            if (this.orientation === 'vertical') {
                pct = 1 - (event.clientY - rect.top) / rect.height;
            } else {
                pct = (event.clientX - rect.left) / rect.width;
            }
            pct = Math.max(0, Math.min(1, pct));
            const raw = this.min + pct * (this.max - this.min);
            this.setThumbValue(this.dragging, raw, true);
        },

        setThumbValue(index, raw, fromPointer) {
            let v = this.clampValue(raw);
            if (this.values.length === 2) {
                if (index === 0) {
                    v = Math.min(v, this.values[1]);
                } else {
                    v = Math.max(v, this.values[0]);
                }
            }
            this.values = this.values.map((prev, i) => (i === index ? v : prev));
            if (fromPointer) {
                this.emitInput();
            }
        },

        onPointerEnd() {
            if (this.dragging === null) {
                return;
            }
            this.dragging = null;
            window.removeEventListener('pointermove', this.boundMove);
            window.removeEventListener('pointerup', this.boundUp);
            window.removeEventListener('pointercancel', this.boundUp);
            this.emitChange();
        },

        onKeydown(index, event) {
            if (this.disabled) {
                return;
            }
            const baseStep = this.step && this.step > 0 ? this.step : (this.max - this.min) / 100;
            let delta = 0;
            if (event.key === 'Home') {
                event.preventDefault();
                this.setThumbValue(index, this.min, false);
                this.emitInput();
                this.emitChange();
                return;
            }
            if (event.key === 'End') {
                event.preventDefault();
                this.setThumbValue(index, this.max, false);
                this.emitInput();
                this.emitChange();
                return;
            }
            if (this.orientation === 'vertical') {
                if (event.key === 'ArrowUp') {
                    delta = baseStep;
                }
                if (event.key === 'ArrowDown') {
                    delta = -baseStep;
                }
            } else {
                if (event.key === 'ArrowRight' || event.key === 'ArrowUp') {
                    delta = baseStep;
                }
                if (event.key === 'ArrowLeft' || event.key === 'ArrowDown') {
                    delta = -baseStep;
                }
            }
            if (delta === 0) {
                return;
            }
            event.preventDefault();
            this.setThumbValue(index, this.values[index] + delta, false);
            this.emitInput();
            this.emitChange();
        },

        emitInput() {
            this.$el.dispatchEvent(
                new CustomEvent('slider-input', {
                    bubbles: true,
                    detail: { values: [...this.values] },
                }),
            );
        },

        emitChange() {
            this.$el.dispatchEvent(
                new CustomEvent('slider-change', {
                    bubbles: true,
                    detail: { values: [...this.values] },
                }),
            );
        },
    }));
});
