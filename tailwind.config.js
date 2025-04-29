/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                indigo: {
                    900: '#1e1b4b',
                    800: '#312e81',
                    700: '#4338ca',
                    600: '#4f46e5',
                },
                emerald: {
                    300: '#6ee7b7',
                    500: '#10b981',
                    600: '#059669',
                },
            },
        },
    },
    plugins: [],
};
