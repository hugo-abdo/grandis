import("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import VTooltip from "v-tooltip";
import Store from "./Store";
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/components/Card.vue";
import can from "./mixins/index";

import "../css/app.css";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => await import(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        el.dataset.page = "";
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VTooltip)
            .use(Store)
            .component("app-layout", AppLayout)
            .component("card", Card)
            .mixin({ methods: { can } })
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
