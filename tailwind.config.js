const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

module.exports = {
    mode: "jit",
    purge: ["./resources/**/*.{js,vue}"],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },

            colors: {
                groadis: ({ opacityValue }) => {
                    if (opacityValue !== undefined) {
                        return `rgba(var(--groadis-color), ${opacityValue})`;
                    }
                    return `rgb(var(--groadis-color))`;
                },
                cyan: colors.cyan,
                fuchsia: colors.fuchsia,
                lightBlue: colors.lightBlue,
                teal: colors.teal,
                orange: colors.orange,
                emerald: colors.emerald,
                sky: colors.sky,
                lime: colors.lime,
            },
            boxShadow: {
                groadis: "0 0 6px 1px rgba(var(--groadis-color),.6)",
            },
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
