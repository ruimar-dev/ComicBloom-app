import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                bloom: {
                    bg:        '#FFF7FB',
                    bgalt:     '#FAF7FF',
                    white:     '#FFFFFF',
                    text:      '#1F2937',
                    muted:     '#6B7280',
                    pink:      '#FF8FAB',
                    'pink-light': '#FFD6E3',
                    purple:    '#B892FF',
                    'purple-light': '#E8DEFF',
                    blue:      '#8BD3FF',
                    'blue-light': '#D6F0FF',
                    yellow:    '#FFE29A',
                    mint:      '#9FF3D4',
                    dark:      '#1E1B2E',
                    'dark-alt':'#2A2542',
                    'dark-card':'#332E50',
                },
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
                '4xl': '2rem',
            },
            boxShadow: {
                soft: '0 2px 20px rgba(184, 146, 255, 0.12)',
                'soft-lg': '0 4px 40px rgba(184, 146, 255, 0.18)',
                card: '0 2px 12px rgba(0,0,0,0.06)',
                'card-hover': '0 8px 30px rgba(184, 146, 255, 0.22)',
            },
        },
    },

    plugins: [forms, typography],
};
