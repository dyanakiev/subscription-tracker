import { Link, router, usePage } from '@inertiajs/react';
import { useMemo, useState } from 'react';
import AppLayout from '../../Layouts/AppLayout';
import { translate } from '../../lib/translate';

const formatNumber = (value, fractionDigits = 2) => {
    const number = Number(value ?? 0);

    return new Intl.NumberFormat(undefined, {
        minimumFractionDigits: fractionDigits,
        maximumFractionDigits: fractionDigits,
    }).format(number);
};

const buildFaviconUrl = (url) => {
    if (!url) {
        return '';
    }

    try {
        const hostname = new URL(url).hostname;
        return hostname ? `https://www.google.com/s2/favicons?domain=${hostname}&sz=64` : '';
    } catch (error) {
        return '';
    }
};

const SubscriptionsIndex = () => {
    const { props } = usePage();
    const {
        subscriptions,
        totalPerMonth,
        totalPerYear,
        currencySymbol,
        compactView,
        statusFilter,
        sortOrder,
        trackedLabel,
        translations,
    } = props;
    const [filtersOpen, setFiltersOpen] = useState(false);

    const t = useMemo(() => {
        return (key, replacements) => translate(translations, key, replacements);
    }, [translations]);

    const updateFilters = (nextStatus, nextSort) => {
        router.get('/subscriptions', {
            status: nextStatus,
            sort: nextSort,
        }, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    };

    const handleDelete = (subscription) => {
        const confirmation = window.confirm(
            t('dialogs.delete_body', { name: subscription.name }),
        );

        if (!confirmation) {
            return;
        }

        router.post(
            `/subscriptions/${subscription.id}`,
            { _method: 'delete' },
            {
                preserveScroll: true,
                headers: {
                    'X-HTTP-Method-Override': 'DELETE',
                },
            },
        );
    };

    return (
        <AppLayout>
            <div className="space-y-8">
                <header className="space-y-4 animate-fade-up">
                    <div className="inline-flex items-center gap-2 rounded-full border border-sky-200/70 bg-sky-100/70 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-sky-700 dark:border-sky-500/40 dark:bg-sky-500/10 dark:text-sky-200">
                        <span className="h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                        {t('badges.monthly_pulse')}
                    </div>
                    <h1 className="text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">
                        {t('headers.subscriptions_glance')}
                    </h1>
                    <p className="text-slate-600 dark:text-slate-400">{t('descriptions.subscription_intro')}</p>
                </header>

                <section className="grid gap-4 sm:grid-cols-2 animate-fade-up animation-delay-150">
                    <div className="app-card p-6">
                        <p className="text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400">{t('stats.total_month')}</p>
                        <p className="text-3xl font-semibold mt-2 text-slate-900 dark:text-white">
                            {formatNumber(totalPerMonth)} {currencySymbol}
                        </p>
                        <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">{t('stats.monthly_spend')}</p>
                    </div>
                    <div className="app-card p-6">
                        <p className="text-xs uppercase tracking-widest text-slate-500 dark:text-slate-400">{t('stats.total_year')}</p>
                        <p className="text-3xl font-semibold mt-2 text-slate-900 dark:text-white">
                            {formatNumber(totalPerYear)} {currencySymbol}
                        </p>
                        <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">{t('stats.annual_total')}</p>
                    </div>
                </section>

                <section>
                    <div className="mb-4 space-y-3">
                        <div className="flex items-center justify-between gap-3">
                            <h2 className="text-2xl font-semibold">{t('subscriptions.active')}</h2>
                            <button
                                type="button"
                                onClick={() => setFiltersOpen((open) => !open)}
                                aria-label={t('subscriptions.filters')}
                                className="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200/80 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 text-slate-600 dark:text-slate-200 shadow-sm transition-colors hover:bg-slate-50 dark:hover:bg-slate-800"
                            >
                                <svg className="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                    <path d="M2 3.5H14M4.5 8H11.5M6.5 12.5H9.5" stroke="currentColor" strokeLinecap="round" strokeWidth="1.5"/>
                                    <circle cx="6" cy="3.5" r="1.5" fill="currentColor"/>
                                    <circle cx="10" cy="8" r="1.5" fill="currentColor"/>
                                    <circle cx="8" cy="12.5" r="1.5" fill="currentColor"/>
                                </svg>
                            </button>
                        </div>
                        <p className="text-sm text-slate-500 dark:text-slate-400">{trackedLabel}</p>

                        {filtersOpen && (
                            <div className="app-card p-4 space-y-3">
                                <div>
                                    <p className="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">{t('subscriptions.filter_label')}</p>
                                    <div className="mt-2 inline-flex rounded-full border border-slate-200/80 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 overflow-hidden text-xs shadow-sm">
                                        <button
                                            type="button"
                                            onClick={() => updateFilters('active', sortOrder)}
                                            className={`px-3 py-1.5 font-semibold transition-colors ${statusFilter === 'active' ? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100' : 'bg-transparent text-slate-500 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100'}`}
                                        >
                                            {t('subscriptions.filter_active')}
                                        </button>
                                        <button
                                            type="button"
                                            onClick={() => updateFilters('inactive', sortOrder)}
                                            className={`px-3 py-1.5 font-semibold transition-colors ${statusFilter === 'inactive' ? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100' : 'bg-transparent text-slate-500 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100'}`}
                                        >
                                            {t('subscriptions.filter_inactive')}
                                        </button>
                                        <button
                                            type="button"
                                            onClick={() => updateFilters('all', sortOrder)}
                                            className={`px-3 py-1.5 font-semibold transition-colors ${statusFilter === 'all' ? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100' : 'bg-transparent text-slate-500 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100'}`}
                                        >
                                            {t('subscriptions.filter_all')}
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <p className="text-xs font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">{t('subscriptions.sort_label')}</p>
                                    <div className="mt-2 inline-flex rounded-full border border-slate-200/80 dark:border-slate-700 bg-white/80 dark:bg-slate-900/70 overflow-hidden text-sm shadow-sm">
                                        <button
                                            type="button"
                                            onClick={() => updateFilters(statusFilter, 'desc')}
                                            aria-label={t('sort.high')}
                                            className={`inline-flex items-center justify-center h-9 w-9 transition-colors ${sortOrder === 'desc' ? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100' : 'bg-transparent text-slate-500 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100'}`}
                                        >
                                            <svg className="h-3.5 w-3.5" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                                <path d="M8 2.5V13.5M8 13.5L4.5 10M8 13.5L11.5 10" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round"/>
                                            </svg>
                                        </button>
                                        <button
                                            type="button"
                                            onClick={() => updateFilters(statusFilter, 'asc')}
                                            aria-label={t('sort.low')}
                                            className={`inline-flex items-center justify-center h-9 w-9 transition-colors ${sortOrder === 'asc' ? 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-100' : 'bg-transparent text-slate-500 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100'}`}
                                        >
                                            <svg className="h-3.5 w-3.5 rotate-180" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                                <path d="M8 2.5V13.5M8 13.5L4.5 10M8 13.5L11.5 10" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>

                    {compactView ? (
                        <div className="space-y-4">
                            {subscriptions.length ? subscriptions.map((subscription) => {
                                const percentage = totalPerMonth > 0 ? (subscription.price / totalPerMonth) * 100 : 0;
                                const faviconUrl = buildFaviconUrl(subscription.url);

                                return (
                                    <div key={subscription.id} className="subscription-card app-card app-card-interactive p-4 space-y-4">
                                        <div className="flex items-center gap-3 flex-1 min-w-0">
                                            {faviconUrl && (
                                                <img src={faviconUrl} alt={`${subscription.name} icon`} className="w-9 h-9 rounded-full bg-white/70 p-1 shrink-0" />
                                            )}
                                            <div className="flex-1 min-w-0">
                                                <p className="text-base font-semibold text-slate-900 dark:text-slate-100 truncate">{subscription.name}</p>
                                                <p className="text-xs text-slate-500 dark:text-slate-400">
                                    {t('subscriptions.of_monthly_spend', { percent: formatNumber(percentage, 1) })}
                                                </p>
                                            </div>
                                        </div>
                                        <div className="flex items-center justify-between gap-4">
                                            <div className="text-right">
                                                <p className="text-lg font-bold text-slate-900 dark:text-slate-100">
                                                    {formatNumber(subscription.price)} {currencySymbol}
                                                    <span className="text-xs font-medium text-slate-500 dark:text-slate-400"> {t('subscriptions.monthly_suffix')}</span>
                                                </p>
                                            </div>
                                            <div className="flex gap-2">
                                                <Link
                                                    href={`/subscriptions/${subscription.id}/edit`}
                                                    aria-label={t('actions.edit_subscription', { name: subscription.name })}
                                                    title={t('actions.edit')}
                                                    className="h-10 w-10 rounded-full bg-sky-100 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 hover:bg-sky-200 dark:hover:bg-sky-800 flex items-center justify-center transition-colors shrink-0"
                                                >
                                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </Link>
                                                <button
                                                    type="button"
                                                    onClick={() => handleDelete(subscription)}
                                                    aria-label={t('actions.delete_subscription', { name: subscription.name })}
                                                    title={t('actions.delete')}
                                                    className="h-10 w-10 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800 flex items-center justify-center transition-colors shrink-0"
                                                >
                                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                );
                            }) : (
                                <div className="text-center py-12">
                                    <p className="text-slate-500 dark:text-slate-400">{t('subscriptions.empty')}</p>
                                </div>
                            )}
                        </div>
                    ) : (
                        <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            {subscriptions.length ? subscriptions.map((subscription) => {
                                const percentage = totalPerMonth > 0 ? (subscription.price / totalPerMonth) * 100 : 0;
                                const faviconUrl = buildFaviconUrl(subscription.url);
                                let colors = {
                                    card: 'bg-white text-slate-900 border border-slate-200 dark:bg-slate-900 dark:text-slate-100 dark:border-slate-800',
                                    accent: 'text-slate-500 dark:text-slate-400',
                                    button: 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800/70 dark:text-slate-200 dark:hover:bg-slate-700/80',
                                };

                                if (subscription.price >= 30) {
                                    colors = {
                                        card: 'bg-gradient-to-br from-rose-600 via-rose-500 to-rose-700 text-white',
                                        accent: 'text-white/85',
                                        button: 'bg-white/15 text-white hover:bg-white/25',
                                    };
                                } else if (subscription.price >= 15) {
                                    colors = {
                                        card: 'bg-gradient-to-br from-amber-500 via-orange-500 to-orange-600 text-white',
                                        accent: 'text-white/85',
                                        button: 'bg-white/15 text-white hover:bg-white/25',
                                    };
                                } else if (subscription.price >= 8) {
                                    colors = {
                                        card: 'bg-gradient-to-br from-sky-600 via-indigo-600 to-indigo-700 text-white',
                                        accent: 'text-white/85',
                                        button: 'bg-white/15 text-white hover:bg-white/25',
                                    };
                                }

                                return (
                                    <div key={subscription.id} className={`subscription-card rounded-2xl shadow p-5 flex flex-col justify-between ${colors.card} app-card-interactive`} style={{ minHeight: '210px' }}>
                                        <div>
                                            <p className={`text-sm uppercase tracking-wide ${colors.accent}`}>{t('subscriptions.monthly')}</p>
                                            <p className="text-3xl font-bold">
                                                {formatNumber(subscription.price)} {currencySymbol}
                                            </p>
                                            <p className={`text-sm ${colors.accent}`}>
                                                {t('subscriptions.of_monthly_spend', { percent: formatNumber(percentage, 1) })}
                                            </p>
                                        </div>
                                        <div>
                                            <div className="flex items-center gap-2">
                                                {faviconUrl && (
                                                    <img src={faviconUrl} alt={`${subscription.name} icon`} className="w-6 h-6 rounded-full bg-white/40 p-1" />
                                                )}
                                                <p className="text-lg font-semibold">{subscription.name}</p>
                                            </div>
                                            <p className={`text-sm ${colors.accent}`}>
                                                {formatNumber(subscription.price * 12)} {currencySymbol} {t('subscriptions.yearly_suffix')}
                                            </p>
                                            <div className="flex gap-2 mt-3">
                                                <Link
                                                    href={`/subscriptions/${subscription.id}/edit`}
                                                    aria-label={t('actions.edit_subscription', { name: subscription.name })}
                                                    title={t('actions.edit')}
                                                    className={`h-10 w-10 rounded-full ${colors.button} flex items-center justify-center transition-colors shrink-0`}
                                                >
                                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </Link>
                                                <button
                                                    type="button"
                                                    onClick={() => handleDelete(subscription)}
                                                    aria-label={t('actions.delete_subscription', { name: subscription.name })}
                                                    title={t('actions.delete')}
                                                    className={`h-10 w-10 rounded-full ${colors.button} flex items-center justify-center transition-colors shrink-0`}
                                                >
                                                    <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                );
                            }) : (
                                <div className="col-span-full text-center py-12">
                                    <p className="text-slate-500 dark:text-slate-400">{t('subscriptions.empty')}</p>
                                </div>
                            )}
                        </div>
                    )}
                </section>
            </div>
        </AppLayout>
    );
};

export default SubscriptionsIndex;
