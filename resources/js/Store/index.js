import { createStore } from "vuex";
import UsersModule from "./UsersModule";
import RolesModule from "./RolesModule";
import actions from "./Actions";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

// Create a new store instance.
export default createStore({
    state: () => ({
        Echo: {},
        isDark: false,
        sideBarActive: false,
        hasNotificatios: false,
        notifications: [],
    }),
    actions,
    mutations: {
        INIT_APP(state) {
            state.Echo = new Echo({
                broadcaster: "pusher",
                key: "GROADISSOCKETSKEY",
                wsHost: "websocket.test",
                wsPort: 6001,
                forceTLS: false,
                disableStats: true,
            });
        },
    },
    modules: {
        UsersModule,
        RolesModule,
    },
});
