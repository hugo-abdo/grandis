import { createStore } from "vuex";
import UsersModule from "./UsersModule";
import RolesModule from "./RolesModule";
import actions from "./Actions";

// Create a new store instance.
export default createStore({
    state: () => ({ isDark: false }),

    actions,
    mutations: {},
    modules: {
        UsersModule,
        RolesModule,
    },
});
