import { Link, useForm, usePage } from '@inertiajs/react';
import { useMemo } from 'react';
import AppLayout from '../../Layouts/AppLayout';
import { translate } from '../../lib/translate';

const SubscriptionForm = () => {
    const { props } = usePage();
    const { subscription, currencySymbol, translations } = props;
    const isEditing = Boolean(subscription);

    const t = useMemo(() => {
        return (key, replacements) => translate(translations, key, replacements);
    }, [translations]);

    const form = useForm(
        subscription
            ? {
                name: subscription.name ?? '',
                price: subscription.price ?? '',
                url: subscription.url ?? '',
                is_active: subscription.isActive ?? true,
            }
            : {
                name: '',
                price: '',
                url: '',
            },
    );

    const submit = (event) => {
        event.preventDefault();

        if (isEditing) {
            form.post(`/subscriptions/${subscription.id}/update`, {
                preserveScroll: true,
            });
        } else {
            form.post('/subscriptions', {
                preserveScroll: true,
            });
        }
    };

    return (
        <AppLayout>
            <div className="space-y-8">
                <header className="space-y-4 animate-fade-up">
                    <div className="inline-flex items-center gap-2 rounded-full border border-emerald-200/70 bg-emerald-100/70 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-200">
                        <span className="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        {isEditing ? t('badges.update') : t('badges.create')}
                    </div>
                    <h1 className="text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">
                        {isEditing ? t('titles.edit_subscription') : t('titles.add_subscription')}
                    </h1>
                    <p className="text-slate-600 dark:text-slate-400">
                        {isEditing ? t('descriptions.subscription_edit') : t('descriptions.subscription_add')}
                    </p>
                </header>

                <div className="app-card-strong p-6 animate-fade-up animation-delay-150">
                    <form onSubmit={submit} className="space-y-5">
                        <div>
                            <label htmlFor="name" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                {t('form.name')}
                            </label>
                            <input
                                type="text"
                                id="name"
                                value={form.data.name}
                                onChange={(event) => form.setData('name', event.target.value)}
                                className="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                                placeholder={t('form.name_placeholder')}
                            />
                            {form.errors.name && (
                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{form.errors.name}</p>
                            )}
                        </div>

                        <div>
                            <label htmlFor="price" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                {t('form.price', { currency: currencySymbol })}
                            </label>
                            <input
                                type="number"
                                id="price"
                                value={form.data.price}
                                onChange={(event) => form.setData('price', event.target.value)}
                                step="0.01"
                                min="0"
                                className="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                                placeholder={t('form.price_placeholder')}
                            />
                            {form.errors.price && (
                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{form.errors.price}</p>
                            )}
                        </div>

                        <div>
                            <label htmlFor="url" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                {t('form.url')}
                            </label>
                            <input
                                type="url"
                                id="url"
                                value={form.data.url ?? ''}
                                onChange={(event) => form.setData('url', event.target.value)}
                                className="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-sky-500 focus:border-transparent"
                                placeholder={t('form.url_placeholder')}
                            />
                            <p className="mt-1 text-xs text-slate-500 dark:text-slate-400">{t('form.url_help')}</p>
                            {form.errors.url && (
                                <p className="mt-1 text-sm text-red-600 dark:text-red-400">{form.errors.url}</p>
                            )}
                        </div>

                        {isEditing && (
                            <div className="flex items-center justify-between rounded-2xl border border-slate-200/80 dark:border-slate-700 bg-slate-50/80 dark:bg-slate-900/50 px-4 py-3">
                                <div>
                                    <p className="text-sm font-medium text-slate-900 dark:text-slate-100">{t('form.active')}</p>
                                    <p className="text-xs text-slate-500 dark:text-slate-400">{t('form.active_help')}</p>
                                </div>
                                <label className="relative inline-flex items-center cursor-pointer">
                                    <input
                                        type="checkbox"
                                        checked={Boolean(form.data.is_active)}
                                        onChange={(event) => form.setData('is_active', event.target.checked)}
                                        className="sr-only peer"
                                    />
                                    <div className="h-6 w-11 rounded-full bg-slate-200 peer-checked:bg-emerald-500 dark:bg-slate-700 transition-colors"></div>
                                    <div className="absolute left-0.5 top-0.5 h-5 w-5 rounded-full bg-white shadow-sm transition-transform peer-checked:translate-x-5"></div>
                                </label>
                            </div>
                        )}

                        <button
                            type="submit"
                            className="w-full px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-xl transition-colors shadow-sm"
                            disabled={form.processing}
                        >
                            {isEditing ? t('form.submit_update') : t('form.submit_add')}
                        </button>

                        {isEditing && (
                            <Link
                                href="/subscriptions"
                                className="w-full px-4 py-2.5 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-slate-100 font-medium rounded-xl transition-colors inline-flex items-center justify-center"
                            >
                                {t('form.cancel')}
                            </Link>
                        )}
                    </form>
                </div>
            </div>
        </AppLayout>
    );
};

export default SubscriptionForm;
