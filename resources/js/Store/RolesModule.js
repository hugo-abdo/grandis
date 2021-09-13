import { debounce } from "lodash";
import { Inertia } from "@inertiajs/inertia";

export default {
    namespaced: true,
    state: () => ({
        roles: [],
    }),
    mutations: {
        INIT(state, p) {
            state.roles = p.roles;
        },
    },
    actions: {},
};
