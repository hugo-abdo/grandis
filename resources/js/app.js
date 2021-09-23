import("./bootstrap");
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import VTooltip from "v-tooltip";
import Store from "./Store";
import AppLayout from "@/Layouts/AppLayout.vue";
import AppHeader from "@/Layouts/Header.vue";
import Card from "@/components/Card.vue";
import can from "./mixins/index";

const appName = document.getElementsByTagName("title")[0]?.innerText || "";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        let app = await import(`./Pages/${name}.vue`);
        app.default.layout = app.default.layout || AppHeader;
        return app;
    },
    setup({ el, app, props, plugin }) {
        el.dataset.page = "page";
        Store.commit("INIT_APP");
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VTooltip)
            .use(Store)
            .component("app-layout", AppLayout)
            .component("card", Card)
            .mixin({ methods: { route, can } })
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
