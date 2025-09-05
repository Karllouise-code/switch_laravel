import { createApp } from "vue";
import { createHead } from "@vueuse/head";
import { createRouter, createWebHistory } from "vue-router";
import VueSweetalert2 from "vue-sweetalert2";
import App from "./App.vue";
import routes_landing from "./routes.js";
import routes_user from "./routes_user.js";
import query from "./queries.js";
import mitt from "mitt";   // 👈 import mitt

import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "sweetalert2/dist/sweetalert2.min.css";


var allRoutes = [];
allRoutes = allRoutes.concat(routes_landing, routes_user);
const routes = allRoutes;

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        const token = sessionStorage.getItem("access-token");
        if (!token) {
            next({ name: "login" });
            return;
        }
        next();
    }
    // if user goes to /login page, clear session storage
    else if (to.name === "login") {
        let token = sessionStorage.getItem("access-token");
        if (token) {
            sessionStorage.clear();
            window.location.href = "/login";
            next();
            return
        } else {
            next();
        }
    } else {
        next();
    }
});

const app = createApp(App);
const head = createHead();

app.use(head);

const emitter = mitt();
app.config.globalProperties.$appEvents = emitter;
app.config.globalProperties.$query = query;
app.config.globalProperties.global_error_message = 'Something went wrong. Please try again later.';

app.use(VueSweetalert2);
app.use(router);

app.mixin({
    created() {
        if (this.$options.metaInfo) {
            this.$head = this.$head || head;
            this.$head.addHeadObjs(this.$options.metaInfo);
        }
    },
});

app.mount("#app");

