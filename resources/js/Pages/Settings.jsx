import { Link, router, usePage } from '@inertiajs/react';
import { useMemo } from 'react';
import AppLayout from '../Layouts/AppLayout';
import { translate } from '../lib/translate';

const Settings = () => {
    const { props } = usePage();
    const { compactView, languages, currencies, locale, currency, translations } = props;

    const t = useMemo(() => {
        return (key, replacements) => translate(translations, key, replacements);
    }, [translations]);

    const updateSetting = (payload) => {
        router.post('/settings', { _method: 'put', ...payload }, {
            preserveScroll: true,
        });
    };

    return (
        <AppLayout>
            <div className="space-y-8">
                <header className="space-y-4 animate-fade-up">
                    <div className="inline-flex items-center gap-2 rounded-full border border-violet-200/70 bg-violet-100/70 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-violet-700 dark:border-violet-500/40 dark:bg-violet-500/10 dark:text-violet-200">
                        <span className="h-1.5 w-1.5 rounded-full bg-violet-500"></span>
                        {t('badges.preferences')}
                    </div>
                    <h1 className="text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">{t('headers.personalize')}</h1>
                    <p className="text-slate-600 dark:text-slate-400 mt-2">{t('descriptions.manage_preferences')}</p>
                </header>

                <div className="app-card-strong p-6 animate-fade-up animation-delay-150">
                    <h3 className="text-xl font-semibold mb-6">{t('settings.display')}</h3>

                    <div className="space-y-4">
                        <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p className="text-sm font-medium text-slate-900 dark:text-slate-100">{t('settings.compact')}</p>
                                <p className="text-sm text-slate-500 dark:text-slate-400">{t('settings.compact_help')}</p>
                            </div>
                            <button
                                type="button"
                                onClick={() => updateSetting({ compact_view: !compactView })}
                                className="inline-flex items-center gap-2 rounded-full border border-slate-200/80 dark:border-slate-700 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-100 bg-white dark:bg-slate-900/50 shadow-sm transition-colors hover:bg-slate-50 dark:hover:bg-slate-800"
                            >
                                <span className={`h-2 w-2 rounded-full ${compactView ? 'bg-emerald-500' : 'bg-slate-400'}`}></span>
                                {compactView ? t('settings.enabled') : t('settings.disabled')}
                            </button>
                        </div>
                        <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p className="text-sm font-medium text-slate-900 dark:text-slate-100">{t('settings.language')}</p>
                                <p className="text-sm text-slate-500 dark:text-slate-400">{t('settings.language_help')}</p>
                            </div>
                            <select
                                value={locale}
                                onChange={(event) => updateSetting({ locale: event.target.value })}
                                className="w-full sm:w-52 rounded-full border border-slate-200/80 dark:border-slate-700 bg-white dark:bg-slate-900/50 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-100 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                            >
                                {Object.entries(languages).map(([value, label]) => (
                                    <option key={value} value={value}>
                                        {label}
                                    </option>
                                ))}
                            </select>
                        </div>
                        <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p className="text-sm font-medium text-slate-900 dark:text-slate-100">{t('settings.currency')}</p>
                                <p className="text-sm text-slate-500 dark:text-slate-400">{t('settings.currency_help')}</p>
                            </div>
                            <select
                                value={currency}
                                onChange={(event) => updateSetting({ currency: event.target.value })}
                                className="w-full sm:w-52 rounded-full border border-slate-200/80 dark:border-slate-700 bg-white dark:bg-slate-900/50 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-100 shadow-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                            >
                                {Object.entries(currencies).map(([value, label]) => (
                                    <option key={value} value={value}>
                                        {value} {label}
                                    </option>
                                ))}
                            </select>
                        </div>
                    </div>
                </div>

                <div className="app-card-strong p-6 animate-fade-up animation-delay-300">
                    <h3 className="text-xl font-semibold mb-6">{t('settings.legal')}</h3>

                    <div className="space-y-4">
                        <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p className="text-sm font-medium text-slate-900 dark:text-slate-100">{t('settings.privacy_policy')}</p>
                                <p className="text-sm text-slate-500 dark:text-slate-400">{t('settings.privacy_policy_help')}</p>
                            </div>
                            <Link
                                href="/privacy-policy"
                                className="inline-flex items-center gap-2 rounded-full border border-slate-200/80 dark:border-slate-700 px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-100 bg-white dark:bg-slate-900/50 shadow-sm transition-colors hover:bg-slate-50 dark:hover:bg-slate-800"
                            >
                                <svg className="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                                {t('settings.view')}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
};

export default Settings;
