const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    purge: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/components/**/*.vue',
    ],

    theme: {
        extend: {

            colors: {
                // Build your palette here
                transparent: 'transparent',
                current: 'currentColor',
                gray: colors.warmGray,
                red: colors.red,
                blue: colors.sky,
                yellow: colors.amber,
                cyan: colors.cyan,
                teal: colors.teal
            },

            blur: {
                xs: '2px',
            },

            fontFamily: {
                sans: ['Open Sans', ...defaultTheme.fontFamily.sans],
            },

            spacing: {
                '1/2': '50%',
                '1/3': '33.333333%',
                '2/3': '66.666667%',
                '1/4': '25%',
                '2/4': '50%',
                '3/4': '75%',
                '1/5': '20%',
                '2/5': '40%',
                '3/5': '60%',
                '4/5': '80%',
                '1/6': '16.666667%',
                '2/6': '33.333333%',
                '3/6': '50%',
                '4/6': '66.666667%',
                '5/6': '83.333333%',
                '1/12': '8.333333%',
                '2/12': '16.666667%',
                '3/12': '25%',
                '4/12': '33.333333%',
                '5/12': '41.666667%',
                '6/12': '50%',
                '7/12': '58.333333%',
                '8/12': '66.666667%',
                '9/12': '75%',
                '10/12': '83.333333%',
                '11/12': '91.666667%',
                '192': '48rem'
            }
        },
    },

    variants: {
        extend: {
            blur: ['hover', 'focus', 'group-hover'],
            opacity: ['disabled'],
            backgroundColor: ['disabled'],

            backdropBlur: ['hover', 'focus', 'group-hover'],
            backdropFilter: ['hover', 'focus', 'group-hover'],
            backdropContrast: ['hover', 'focus', 'group-hover'],
            backdropBrightness: ['hover', 'focus', 'group-hover'],
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('tailwindcss-textshadow'),
        require('@tailwindcss/line-clamp'),
        require('@tailwindcss/typography'),
    ],
};
