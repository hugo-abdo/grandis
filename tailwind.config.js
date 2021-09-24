const defaultTheme = require("tailwindcss/defaultTheme");
const colors = require("tailwindcss/colors");

module.exports = {
    mode: "jit",
    purge: ["./resources/**/*.{js,vue,php}"],
    darkMode: "class",
    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                groadis: colors.indigo[400],
                "groadis-dark": colors.coolGray[800],
                "groadis-darker": colors.coolGray[900],
                gray: colors.coolGray,
                coolGray: colors.gray,
                cyan: colors.cyan,
                fuchsia: colors.fuchsia,
                sky: colors.sky,
                teal: colors.teal,
                orange: colors.orange,
                emerald: colors.emerald,
                sky: colors.sky,
                lime: colors.lime,
            },
            boxShadow: {
                groadis: "0 0 6px 1px rgba(var(--groadis-color),.6)",
                r: "inset 5px 2px 4px 0 rgba(0, 0, 0, 0.06)",
            },
        },
    },
    variants: {
        scrollbar: ["rounded", "dark"],
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("@windicss/plugin-scrollbar"),
    ],
};
