/** @format */
import path from "path";
import vue from "@vitejs/plugin-vue";

export default ({ command }) => ({
    base: command === "serve" ? "" : "/vandor/",
    publicDir: "fake_dir",
    build: {
        outDir: "public/vandor",
        rollupOptions: {
            input: ["./resources/js/app.js", "./resources/css/app.css"],
        },
        polyfillDynamicImport: false,
    },
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "./resources/js/"),
            "@components": path.resolve(
                __dirname,
                "./resources/js/components/"
            ),
        },
    },
    plugins: [vue()],
});
