import { createElement } from 'react';
import { createRoot } from 'react-dom/client';
import { loadPhosphorIcon, normalizePhosphorWeight } from './phosphor-registry.jsx';

const phosphorRoots = new WeakMap();

/**
 * @param {HTMLElement} el
 * @param {import('react-dom/client').Root} reactRoot
 */
function safeUnmountRoot(el, reactRoot) {
    try {
        reactRoot.unmount();
    } catch {
        // Morph externo (ex.: Livewire) pode ter removido nós que o React ainda esperava desmontar.
        while (el.firstChild) {
            el.removeChild(el.firstChild);
        }
    } finally {
        phosphorRoots.delete(el);
    }
}

/**
 * Monta ícones Phosphor em nós `[data-phosphor-icon]` (React).
 *
 * @param {ParentNode} [root]
 * @returns {Promise<void>}
 */
export async function initPhosphorIcons(root = document) {
    const nodes = [...root.querySelectorAll('[data-phosphor-icon]')];

    for (const el of nodes) {
        await mountPhosphorIcon(el);
    }
}

/**
 * @param {Element} el
 */
async function mountPhosphorIcon(el) {
    if (!(el instanceof HTMLElement)) {
        return;
    }

    const host = /** @type {HTMLElement} */ (el.querySelector('[data-phosphor-react-root]') ?? el);

    if (el.dataset.phosphorMounted === 'pending') {
        return;
    }

    const className = host.getAttribute('class') ?? '';
    const iconName = el.dataset.name ?? '';

    if (el.dataset.phosphorMounted === '1') {
        const sameMeta =
            className === (el.dataset.phosphorLastClass ?? '') &&
            iconName === (el.dataset.phosphorLastIconName ?? '');
        // Livewire morph pode limpar filhos do span (HTML do servidor vem vazio) mantendo o mesmo nó;
        // nesse caso ainda temos mounted=1 e sameMeta, mas o React perdeu o DOM — temos de remontar.
        const domIntact = host.firstElementChild != null;

        if (sameMeta && domIntact) {
            return;
        }

        const oldRoot = phosphorRoots.get(host);

        if (oldRoot) {
            safeUnmountRoot(host, oldRoot);
        }

        delete el.dataset.phosphorMounted;
        delete el.dataset.phosphorLastClass;
        delete el.dataset.phosphorLastIconName;
    }

    el.dataset.phosphorMounted = 'pending';

    try {
        const Icon = await loadPhosphorIcon(iconName);

        if (!Icon) {
            if (import.meta.env.DEV) {
                console.warn(`[phosphor] Ícone não encontrado: "${iconName}"`);
            }

            delete el.dataset.phosphorMounted;

            return;
        }

        if (el.dataset.phosphorMounted !== 'pending') {
            return;
        }

        const weight = normalizePhosphorWeight(el.dataset.weight);
        const snapshotClass = host.getAttribute('class') ?? '';
        const ariaLabel = el.getAttribute('data-aria-label');

        const props = {
            weight,
            className: snapshotClass,
            ...(ariaLabel ? { 'aria-label': ariaLabel, role: 'img' } : { 'aria-hidden': true }),
        };

        let reactRoot = phosphorRoots.get(host);

        if (!reactRoot) {
            reactRoot = createRoot(host);
            phosphorRoots.set(host, reactRoot);
        }

        reactRoot.render(createElement(Icon, props));

        // Não inspecionar firstElementChild aqui: no React 18 o commit no DOM pode ser
        // assíncrono; verificação síncrona vê sempre vazio e desmontava todas as raízes.

        el.dataset.phosphorMounted = '1';
        el.dataset.phosphorLastClass = snapshotClass;
        el.dataset.phosphorLastIconName = iconName;
    } catch (error) {
        delete el.dataset.phosphorMounted;
        delete el.dataset.phosphorLastClass;
        delete el.dataset.phosphorLastIconName;

        throw error;
    }
}

if (import.meta.hot) {
    import.meta.hot.dispose(() => {
        document.querySelectorAll('[data-phosphor-icon]').forEach((el) => {
            if (!(el instanceof HTMLElement)) {
                return;
            }

            const host = /** @type {HTMLElement} */ (el.querySelector('[data-phosphor-react-root]') ?? el);
            const root = phosphorRoots.get(host);

            if (root) {
                safeUnmountRoot(host, root);
            }

            delete el.dataset.phosphorMounted;
            delete el.dataset.phosphorLastClass;
            delete el.dataset.phosphorLastIconName;
        });
    });
}
