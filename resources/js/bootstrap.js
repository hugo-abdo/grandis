/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";
import Pusher from "pusher-js";

if (!window.Echo) {
    window.Echo = new Echo({
        broadcaster: "pusher",
        key: "GROADISSOCKETSKEY",
        wsHost: "websocket.test",
        wsPort: 6001,
        forceTLS: false,
        disableStats: true,
    });
}
