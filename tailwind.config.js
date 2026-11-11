import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: { DEFAULT: '#10B981', dark: '#059669', tint: '#D1FAE5' },
                navy: '#0F1B33',
                app: '#F4F6F8',
                ink: { DEFAULT: '#0F172A', muted: '#64748B' },
                line: '#E5E7EB',
                status: {
                    paid: '#059669', pending: '#D97706',
                    unpaid: '#64748B', rejected: '#DC2626',
                },
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: { card: '20px', hero: '24px', input: '16px' },
            boxShadow: {
                card: '0 1px 3px rgba(15,23,42,.04), 0 4px 12px rgba(15,23,42,.03)',
                hero: '0 8px 24px -4px rgba(15,27,51,.12), 0 4px 8px -2px rgba(16,185,129,.08)',
                sheet: '0 -8px 32px rgba(15,23,42,.12)',
            },
        },
    },
    plugins: [forms],
};
