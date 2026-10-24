import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    // light theme only: ignore the visitor's OS dark mode
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Manrope', ...defaultTheme.fontFamily.sans],
                display: ['"Bricolage Grotesque"', 'Manrope', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                ink:   { DEFAULT: '#0f2a2e', soft: '#31484c' },
                brand: { DEFAULT: '#0d7377', dark: '#095659', tint: '#def1f0' },
                mist:  '#eef3f2',
                edge:  '#d6e2e0',
                signal:'#2dbd73',
                alert: '#c8412f',
            },
            boxShadow: {
                panel: '0 1px 2px rgba(15,42,46,.06), 0 12px 32px -12px rgba(15,42,46,.18)',
            },
        },
    },

    plugins: [forms],
};