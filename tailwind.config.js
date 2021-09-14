const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

module.exports = {
    mode: "jit",
    purge: ["./resources/**/*.{js,vue}"],
    darkMode: "class",
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
                "groadis-dark": colors.coolGray[800],
                "groadis-darker": colors.coolGray[900],
                gray: colors.coolGray,
                coolGray: colors.gray,
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
