import { createContext, useContext, useMemo } from 'react';
import { createRoot } from 'react-dom/client';
import {
    Bar,
    BarChart,
    CartesianGrid,
    Legend,
    Line,
    LineChart,
    ResponsiveContainer,
    Tooltip,
    XAxis,
    YAxis,
} from 'recharts';

const ChartContext = createContext(null);

function useChart() {
    const context = useContext(ChartContext);

    if (!context) {
        throw new Error('useChart must be used within a ChartContainer');
    }

    return context;
}

function cn(...inputs) {
    return inputs.flat(Infinity).filter(Boolean).join(' ');
}

function getPayloadConfigFromPayload(config, payload, key) {
    if (typeof payload !== 'object' || payload === null) {
        return undefined;
    }

    const payloadPayload =
        'payload' in payload && typeof payload.payload === 'object' && payload.payload !== null
            ? payload.payload
            : undefined;

    let configLabelKey = key;

    if (key in payload && typeof payload[key] === 'string') {
        configLabelKey = payload[key];
    } else if (
        payloadPayload &&
        key in payloadPayload &&
        typeof payloadPayload[key] === 'string'
    ) {
        configLabelKey = payloadPayload[key];
    }

    return configLabelKey in config ? config[configLabelKey] : config[key];
}

export function ChartTooltipContent({
    active,
    payload,
    className,
    indicator = 'dot',
    hideLabel = false,
    hideIndicator = false,
    label,
    labelFormatter,
    labelClassName,
    formatter,
    color,
    nameKey,
    labelKey,
}) {
    const { config } = useChart();

    const tooltipLabel = useMemo(() => {
        if (hideLabel || !payload?.length) {
            return null;
        }

        const [item] = payload;
        const key = `${labelKey ?? item?.dataKey ?? item?.name ?? 'value'}`;
        const itemConfig = getPayloadConfigFromPayload(config, item, key);
        const value =
            !labelKey && typeof label === 'string' ? (config[label]?.label ?? label) : itemConfig?.label;

        if (labelFormatter) {
            return (
                <div className={cn('font-medium', labelClassName)}>{labelFormatter(value, payload)}</div>
            );
        }

        if (!value) {
            return null;
        }

        return <div className={cn('font-medium', labelClassName)}>{value}</div>;
    }, [label, labelFormatter, payload, hideLabel, labelClassName, config, labelKey]);

    if (!active || !payload?.length) {
        return null;
    }

    const nestLabel = payload.length === 1 && indicator !== 'dot';

    return (
        <div
            className={cn(
                'grid min-w-32 items-start gap-1.5 rounded-lg border border-border/50 bg-background px-2.5 py-1.5 text-xs shadow-xl',
                className,
            )}
        >
            {!nestLabel ? tooltipLabel : null}
            <div className="grid gap-1.5">
                {payload
                    .filter((item) => item.type !== 'none')
                    .map((item, index) => {
                        const key = `${nameKey ?? item.name ?? item.dataKey ?? 'value'}`;
                        const itemConfig = getPayloadConfigFromPayload(config, item, key);
                        const indicatorColor = color ?? item.payload?.fill ?? item.color;

                        return (
                            <div
                                key={index}
                                className={cn(
                                    'flex w-full flex-wrap items-stretch gap-2 [&>svg]:h-2.5 [&>svg]:w-2.5 [&>svg]:text-muted-foreground',
                                    indicator === 'dot' && 'items-center',
                                )}
                            >
                                {formatter && item?.value !== undefined && item.name ? (
                                    formatter(item.value, item.name, item, index, item.payload)
                                ) : (
                                    <>
                                        {!hideIndicator ? (
                                            <div
                                                className={cn('shrink-0 rounded-[2px] border-(--color-border) bg-(--color-bg)', {
                                                    'h-2.5 w-2.5': indicator === 'dot',
                                                    'w-1': indicator === 'line',
                                                    'w-0 border-[1.5px] border-dashed bg-transparent':
                                                        indicator === 'dashed',
                                                    'my-0.5': nestLabel && indicator === 'dashed',
                                                })}
                                                style={{
                                                    '--color-bg': indicatorColor,
                                                    '--color-border': indicatorColor,
                                                }}
                                            />
                                        ) : null}
                                        <div
                                            className={cn(
                                                'flex flex-1 justify-between leading-none',
                                                nestLabel ? 'items-end' : 'items-center',
                                            )}
                                        >
                                            <div className="grid gap-1.5">
                                                {nestLabel ? tooltipLabel : null}
                                                <span className="text-muted-foreground">
                                                    {itemConfig?.label ?? item.name}
                                                </span>
                                            </div>
                                            {item.value != null && (
                                                <span className="font-mono font-medium text-foreground tabular-nums">
                                                    {typeof item.value === 'number'
                                                        ? item.value.toLocaleString()
                                                        : String(item.value)}
                                                </span>
                                            )}
                                        </div>
                                    </>
                                )}
                            </div>
                        );
                    })}
            </div>
        </div>
    );
}

export function ChartLegendContent({
    className,
    hideIcon = false,
    payload,
    verticalAlign = 'bottom',
    nameKey,
}) {
    const { config } = useChart();

    if (!payload?.length) {
        return null;
    }

    return (
        <div
            className={cn(
                'flex items-center justify-center gap-4',
                verticalAlign === 'top' ? 'pb-3' : 'pt-3',
                className,
            )}
        >
            {payload
                .filter((item) => item.type !== 'none')
                .map((item, index) => {
                    const key = `${nameKey ?? item.dataKey ?? 'value'}`;
                    const itemConfig = getPayloadConfigFromPayload(config, item, key);

                    return (
                        <div
                            key={index}
                            className="flex items-center gap-1.5 [&>svg]:h-3 [&>svg]:w-3 [&>svg]:text-muted-foreground"
                        >
                            {!hideIcon ? (
                                <div
                                    className="h-2 w-2 shrink-0 rounded-[2px]"
                                    style={{
                                        backgroundColor: item.color,
                                    }}
                                />
                            ) : null}
                            {itemConfig?.label ?? item.value}
                        </div>
                    );
                })}
        </div>
    );
}

export const ChartTooltip = Tooltip;

function resolveXKey(data, config, explicit) {
    if (explicit) {
        return explicit;
    }

    if (!data?.[0]) {
        return 'name';
    }

    const seriesKeys = new Set(Object.keys(config ?? {}));
    const rowKeys = Object.keys(data[0]);
    const candidate = rowKeys.find((k) => !seriesKeys.has(k));

    return candidate ?? rowKeys[0] ?? 'name';
}

function seriesKeysFromData(data, config) {
    const keys = Object.keys(config ?? {});
    if (!data?.[0]) {
        return keys;
    }

    const row = data[0];

    return keys.filter((k) => k in row);
}

function ChartByType({ type, data, config, xKey }) {
    const x = resolveXKey(data, config, xKey);
    const keys = seriesKeysFromData(data, config);

    if (type === 'bar') {
        return (
            <BarChart data={data} margin={{ top: 8, right: 12, left: 4, bottom: 8 }}>
                <CartesianGrid vertical={false} strokeDasharray="3 3" />
                <XAxis dataKey={x} tickLine={false} axisLine={false} tickMargin={8} />
                <YAxis tickLine={false} axisLine={false} tickMargin={8} />
                <Tooltip content={<ChartTooltipContent />} cursor={{ stroke: 'hsl(var(--border))' }} />
                <Legend content={<ChartLegendContent />} />
                {keys.map((k) => (
                    <Bar key={k} dataKey={k} fill={`var(--color-${k})`} radius={4} />
                ))}
            </BarChart>
        );
    }

    return (
        <LineChart data={data} margin={{ top: 8, right: 12, left: 4, bottom: 8 }}>
            <CartesianGrid strokeDasharray="3 3" />
            <XAxis dataKey={x} tickLine={false} axisLine={false} tickMargin={8} />
            <YAxis tickLine={false} axisLine={false} tickMargin={8} />
            <Tooltip content={<ChartTooltipContent />} />
            <Legend content={<ChartLegendContent />} />
            {keys.map((k) => (
                <Line
                    key={k}
                    type="monotone"
                    dataKey={k}
                    stroke={`var(--color-${k})`}
                    strokeWidth={2}
                    dot={false}
                />
            ))}
        </LineChart>
    );
}

function ChartRoot({ config, initialDimension, className, children }) {
    return (
        <ChartContext.Provider value={{ config }}>
            <ResponsiveContainer
                width="100%"
                height="100%"
                initialDimension={initialDimension}
                className={cn('size-full', className)}
            >
                {children}
            </ResponsiveContainer>
        </ChartContext.Provider>
    );
}

const mountedRoots = new WeakMap();

export function initUiCharts() {
    document.querySelectorAll('[data-ui-chart]').forEach((el) => {
        if (mountedRoots.has(el) || el.dataset.uiChartMounted === '1') {
            return;
        }

        let config = {};
        let series = [];

        try {
            config = JSON.parse(el.getAttribute('data-chart-config') || '{}');
        } catch {
            config = {};
        }

        try {
            series = JSON.parse(el.getAttribute('data-chart-series') || '[]');
        } catch {
            series = [];
        }

        const type = el.getAttribute('data-chart-type') || 'line';
        const xKey = el.getAttribute('data-chart-index-key') || undefined;
        const initialDimension = {
            width: Number(el.getAttribute('data-chart-initial-width')) || 320,
            height: Number(el.getAttribute('data-chart-initial-height')) || 200,
        };

        const root = createRoot(el);

        mountedRoots.set(el, root);
        el.dataset.uiChartMounted = '1';

        root.render(
            <ChartRoot config={config} initialDimension={initialDimension} className={el.className}>
                <ChartByType type={type} data={series} config={config} xKey={xKey} />
            </ChartRoot>,
        );
    });
}

if (import.meta.hot) {
    import.meta.hot.dispose(() => {
        document.querySelectorAll('[data-ui-chart]').forEach((el) => {
            const root = mountedRoots.get(el);

            if (root) {
                root.unmount();
            }

            delete el.dataset.uiChartMounted;
        });
    });
}

export { getPayloadConfigFromPayload, useChart };
