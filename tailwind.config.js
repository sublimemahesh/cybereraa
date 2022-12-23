const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    mode: "jit",
    darkMode: "class",
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Http/Livewire/**/*Table.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: 'var(--primary)',
                secondary: 'var(--secondary)',
                'secondary-dark': 'var(--secondary-dark)',
                'primary-hover': 'var(--primary-hover)',
                'primary-dark': 'var(--primary-dark)',
                tertiary: '#777',
                transparent: 'transparent',
                current: 'currentColor',
                black: colors.black,
                white: colors.white,
                gray: colors.gray,
                emerald: colors.emerald,
                indigo: colors.indigo,
                yellow: colors.yellow,
            }
        },
        dark: {
            colors: {
                primary: 'var(--primary)',
                secondary: 'var(--secondary)',
                'secondary-dark': 'var(--secondary-dark)',
                'primary-hover': 'var(--primary-hover)',
                'primary-dark': 'var(--primary-dark)',
                tertiary: '#ccc',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms')({
            strategy: 'class',
        }),
        require('tailwindcss-dark-mode')(),
        require("@tailwindcss/typography"),
    ],
};
