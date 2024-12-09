import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                colors: {
                    primary: {
                        100: '#022964',
                        90: '#033D96',
                        80: '#0351C9',
                        70: '#0465FB',
                        60: '#3684FC',
                        50: '#69A3FC',
                        40: '#9BC2FD',
                        30: '#CDE0FE',
                        20: '#E6F0FF',
                        10: '#F2F7FF',
                    },
                    secondary: {
                        100: '#0B331C',
                        90: '#092A17',
                        80: '#12542E',
                        70: '#1B7E45',
                        60: '#25A75C',
                        50: '#2DD273',
                        40: '#58DA8F',
                        30: '#81E4AB',
                        20: '#ABEDC7',
                        10: '#D5F6E3',
                    },
                    tertiary: {
                        100: '#000000',
                        90: '#332000',
                        80: '#664000',
                        70: '#996000',
                        60: '#CC8000',
                        50: '#FFA001',
                        40: '#FFB333',
                        30: '#FFC666',
                        20: '#FFD999',
                        10: '#FFECCC',
                    },
                    natural: {
                        0: '#09101D',
                        1: '#2C3A4B',
                        2: '#394452',
                        3: '#545D69',
                        4: '#6D7580',
                        5: '#858C94',
                        6: '#A5ABB3',
                        7: '#DADEE3',
                        8: '#EBEEF2',
                        9: '#F4F6F9',
                    },
                    state: {
                        success: '#287D3C',
                        warning: '#FD6F03',
                        error: '#DA1414',
                        info: '#F610BD',
                    },
                },
            },
        },

        plugins: [forms],
    },
};
