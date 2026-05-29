import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class', // Permite controlar el modo oscuro mediante clases
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Registro de los colores de American Iron
                'brand-neon': '#ccff00', 
                'brand-dark': '#0a0a0a',
                'brand-card': '#141414',
            },
        },
    },
    plugins: [forms],
};