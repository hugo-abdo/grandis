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
        notifications: [],
        banners: [],
    }),
    getters: {
        isDark: (state) => state.isDark,
        hasNotificatios: (state) => {
            let hasNotificatios = false;
            state.notifications.map((n) => {
                if (!n.read_at) {
                    hasNotificatios = true;
                }
            });
            return hasNotificatios;
        },
    },
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
        HANDEL_NOTIFICATIONS(state, notification) {
            // state.hasNotificatios = true;
            state.notifications.unshift({ ...notification, read_at: null });
            state.banners.push({
                id: notification.id,
                banner: notification.message,
                bannerStyle: "notification",
                user: notification.user,
            });
        },
    },
    modules: {
        UsersModule,
        RolesModule,
    },
    actions,
});
