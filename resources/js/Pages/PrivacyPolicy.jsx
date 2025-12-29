import { useMemo } from 'react';
import { usePage } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { translate } from '../lib/translate';

const PrivacyPolicy = () => {
    const { props } = usePage();
    const { effectiveDate, translations } = props;

    const t = useMemo(() => {
        return (key, replacements) => translate(translations, key, replacements);
    }, [translations]);

    return (
        <AppLayout>
            <div className="space-y-8">
                <header className="space-y-4 animate-fade-up">
                    <div className="inline-flex items-center gap-2 rounded-full border border-emerald-200/70 bg-emerald-100/70 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-200">
                        <span className="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        {t('settings.legal')}
                    </div>
                    <h1 className="text-3xl font-semibold tracking-tight text-slate-900 dark:text-white">{t('settings.privacy_policy')}</h1>
                    <p className="text-slate-600 dark:text-slate-400">{t('settings.privacy_policy_help')}</p>
                </header>

                <div className="app-card-strong p-6 space-y-6 animate-fade-up animation-delay-150">
                    <div className="space-y-3">
                        <p className="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Effective date</p>
                        <p className="text-lg font-semibold text-slate-900 dark:text-white">{effectiveDate}</p>
                    </div>

                    <div className="rounded-2xl border border-emerald-200/70 bg-emerald-50/80 p-4 text-sm text-emerald-900 shadow-sm dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-100">
                        <p>
                            This privacy policy is provided for Apple App Store and Google Play compliance.
                            Subscription Tracker does not collect, transmit, or sell personal information. All data
                            you enter stays on your device.
                        </p>
                    </div>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">Information we collect</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            Subscription Tracker does not collect, transmit, or store any personal information, usage data, or analytics.
                            The app operates entirely offline and stores all data locally on your device using SQLite database. The only data stored includes:
                        </p>
                        <ul className="grid gap-2 text-slate-600 dark:text-slate-300">
                            <li>Subscription names, prices, and URLs that you manually enter</li>
                            <li>Your app preferences (currency, language, view settings) stored locally on your device</li>
                        </ul>
                        <p className="text-slate-600 dark:text-slate-300">
                            We do not have access to this data, and it is never transmitted to our servers or any third parties.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">How we use information</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            Since we do not collect any information, we do not use any personal data. All subscription data you enter
                            is used solely within the app on your device to display your subscriptions and calculate totals.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">Data storage and security</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            All data you enter in the app is stored locally on your device's storage using SQLite database. We do not
                            operate backend servers for storing your data, and we do not have access to it.
                        </p>
                        <p className="text-slate-600 dark:text-slate-300">
                            Your data is protected by your device's built-in security measures. We recommend keeping your device
                            protected with a passcode, biometric authentication, or other security measures provided by your device
                            manufacturer.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">Third-party services</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            The app may display website favicons (small icons) by loading them from Google's favicon service
                            (google.com/s2/favicons). This service is used solely to display visual icons for subscription websites
                            and does not involve transmitting any personal data or subscription information. The favicon requests
                            only include the domain name of the subscription URL you entered, and no other personal information.
                        </p>
                        <p className="text-slate-600 dark:text-slate-300">
                            Google's privacy policy applies to their favicon service. We do not control how Google handles data
                            from these requests. You can review Google's privacy policy at
                            <a className="font-semibold text-slate-900 underline decoration-emerald-300/80 underline-offset-4 dark:text-white dark:decoration-emerald-400/60" href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer"> https://policies.google.com/privacy</a>.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">Permissions</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            The app requests the following permission:
                        </p>
                        <ul className="grid gap-2 text-slate-600 dark:text-slate-300">
                            <li><span className="font-semibold text-slate-900 dark:text-white">Network state</span>: Used to check your device's internet connectivity status. This permission does not allow the app to access your network traffic or transmit any data.</li>
                        </ul>
                        <p className="text-slate-600 dark:text-slate-300">
                            The app does not request access to camera, microphone, location, contacts, or any other sensitive permissions.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">Data retention and deletion</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            Since all data is stored locally on your device, you have complete control over your data:
                        </p>
                        <ul className="grid gap-2 text-slate-600 dark:text-slate-300">
                            <li>You can delete individual subscriptions at any time within the app</li>
                            <li>You can uninstall the app to remove all stored data from your device</li>
                            <li>Data is retained on your device until you delete it or uninstall the app</li>
                        </ul>
                        <p className="text-slate-600 dark:text-slate-300">
                            If you would like to request assistance with data deletion or have questions about your data, please contact us using the information provided in the Contact section below.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">Sharing of information</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            We do not share, sell, or transmit any data with third parties because we do not collect it. Your subscription data remains on your device and is never sent to our servers or any external services.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">Your rights</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            You have the following rights regarding your data:
                        </p>
                        <ul className="grid gap-2 text-slate-600 dark:text-slate-300">
                            <li><span className="font-semibold text-slate-900 dark:text-white">Right to access</span>: You can view all your data directly within the app</li>
                            <li><span className="font-semibold text-slate-900 dark:text-white">Right to deletion</span>: You can delete any subscription or uninstall the app to remove all data</li>
                            <li><span className="font-semibold text-slate-900 dark:text-white">Right to data portability</span>: Since data is stored locally, you have full control and can export it if needed</li>
                        </ul>
                        <p className="text-slate-600 dark:text-slate-300">
                            If you have any questions or wish to exercise these rights, please contact us using the information provided below.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">Children's privacy</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            Subscription Tracker is not directed to children under 13 (or the applicable age of consent in your jurisdiction), and we do not knowingly collect
                            personal information from children. If you are a parent or guardian and believe your child has provided us with personal information, please contact us immediately.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">International users</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            This app is designed to work locally on your device regardless of your location. Since we do not collect or transmit any data, no data crosses international borders. All data processing occurs entirely on your device.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">Changes to this policy</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            We may update this privacy policy from time to time. If we make material changes, we will revise the effective date at the top of this page. We encourage you to review this policy periodically to stay informed about how we protect your privacy.
                        </p>
                        <p className="text-slate-600 dark:text-slate-300">
                            Your continued use of the app after any changes to this policy constitutes acceptance of those changes.
                        </p>
                    </section>

                    <section className="space-y-3">
                        <h2 className="text-xl font-semibold text-slate-900 dark:text-white">Contact</h2>
                        <p className="text-slate-600 dark:text-slate-300">
                            If you have questions, concerns, or requests regarding this privacy policy or your data, please contact us:
                        </p>
                        <ul className="grid gap-2 text-slate-600 dark:text-slate-300">
                            <li><span className="font-semibold text-slate-900 dark:text-white">Developer</span>: Dimitar Yanakiev</li>
                            <li><span className="font-semibold text-slate-900 dark:text-white">Email</span>: app@webticus.com</li>
                            <li><span className="font-semibold text-slate-900 dark:text-white">Support Email</span>: app@webticus.com</li>
                        </ul>
                    </section>
                </div>
            </div>
        </AppLayout>
    );
};

export default PrivacyPolicy;
