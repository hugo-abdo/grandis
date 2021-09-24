import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import VTooltip from "v-tooltip";
import Store from "./Store";
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/components/Card.vue";
import can from "./mixins/index";

const appName = document.getElementsByTagName("title")[0]?.innerText || "";
const pages = import.meta.glob("./Pages/**/*.vue");

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const importPage = pages[`./Pages/${name}.vue`];
        if (!importPage) {
            throw new Error(
                `Unknown page ${name}. Is it located under Pages with a .vue extension?`
            );
        }
        return importPage().then(({ default: page }) => {
            page.layout = page.layout || h(AppLayout, { title: page.name });
            return page;
        });
    },
    setup({ el, app, props, plugin }) {
        el.dataset.page = "page";
        Store.commit("INIT_APP");
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VTooltip)
            .use(Store)
            .component("card", Card)
            .mixin({ methods: { route, can } })
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
