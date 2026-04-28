/**
 * Phosphor Icons (React) — carregamento por nome em kebab-case.
 * Usa import.meta.glob para o Vite emitir chunks com URLs relativas (o import() dinâmico
 * com string + pacote npm não funciona no browser em produção).
 *
 * @see https://phosphoricons.com/
 */

const phosphorIconLoaders = import.meta.glob('../../../node_modules/@phosphor-icons/react/dist/csr/*.es.js');

/** @type {Record<string, () => Promise<unknown>>} */
const loaderByPascalBase = {};

for (const [path, load] of Object.entries(phosphorIconLoaders)) {
    const match = path.match(/\/([^/]+)\.es\.js$/);

    if (!match) {
        continue;
    }

    const base = match[1];

    if (typeof load === 'function') {
        loaderByPascalBase[base] = load;
    }
}

/** @type {Record<string, string>} kebab-case → nome do módulo (PascalCase, sem .es.js) */
const phosphorAliases = {
    'chevron-down': 'CaretDown',
    'chevron-left': 'CaretLeft',
    'chevron-right': 'CaretRight',
    'chevron-up': 'CaretUp',
    'circle-notch': 'CircleNotch',
    loader: 'CircleNotch',
    'loader-2': 'CircleNotch',
    'list-bullets': 'ListBullets',
    'magnifying-glass': 'MagnifyingGlass',
    'more-horizontal': 'DotsThree',
    'panel-left': 'SidebarSimple',
    search: 'MagnifyingGlass',
    windows: 'WindowsLogo',
    'windows-logo': 'WindowsLogo',
};

const allowedWeights = new Set(['thin', 'light', 'regular', 'bold', 'fill', 'duotone']);

/** @type {Map<string, Promise<import('react').ComponentType<any>|null>>} */
const iconLoadCache = new Map();

/**
 * @param {string|null|undefined} raw
 */
function normalizeIconKey(raw) {
    return String(raw ?? '')
        .toLowerCase()
        .trim()
        .replace(/_/g, '-');
}

/**
 * @param {string} kebab
 */
export function kebabToPascal(kebab) {
    return normalizeIconKey(kebab)
        .split('-')
        .filter(Boolean)
        .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
        .join('');
}

/**
 * Nome do ficheiro em dist/csr (sem extensão).
 *
 * @param {string|null|undefined} raw
 */
export function getPhosphorModuleBaseName(raw) {
    const key = normalizeIconKey(raw);

    if (key === '') {
        return '';
    }

    if (Object.prototype.hasOwnProperty.call(phosphorAliases, key)) {
        return phosphorAliases[key];
    }

    return kebabToPascal(key);
}

/**
 * @param {string} base
 */
function getLoaderForBase(base) {
    const load = loaderByPascalBase[base];

    return typeof load === 'function' ? load : null;
}

/**
 * @param {string|null|undefined} name
 * @returns {Promise<import('react').ComponentType<any>|null>}
 */
export function loadPhosphorIcon(name) {
    const key = normalizeIconKey(name);

    if (key === '') {
        return Promise.resolve(null);
    }

    if (iconLoadCache.has(key)) {
        return /** @type {Promise<import('react').ComponentType<any>|null>} */ (iconLoadCache.get(key));
    }

    const base = getPhosphorModuleBaseName(name);

    if (base === '') {
        const empty = Promise.resolve(null);
        iconLoadCache.set(key, empty);

        return empty;
    }

    const loader = getLoaderForBase(base);

    if (!loader) {
        const missing = Promise.resolve(null);
        iconLoadCache.set(key, missing);

        return missing;
    }

    const promise = loader()
        .then((mod) => {
            const bundle = /** @type {Record<string, import('react').ComponentType<any>>} */ (mod);
            const Icon = bundle[`${base}Icon`] ?? bundle[base];

            return Icon ?? null;
        })
        .catch(() => null);

    iconLoadCache.set(key, promise);

    return promise;
}

/**
 * @param {string|null|undefined} raw
 */
export function normalizePhosphorWeight(raw) {
    let w = String(raw ?? 'regular')
        .toLowerCase()
        .trim();

    if (w === 'solid') {
        w = 'fill';
    }

    return allowedWeights.has(w) ? w : 'regular';
}
