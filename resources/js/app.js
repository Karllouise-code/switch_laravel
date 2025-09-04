import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import VueSweetalert2 from "vue-sweetalert2";
import App from "./App.vue";
import routes from "./routes.js";
import query from "./queries.js";

import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "sweetalert2/dist/sweetalert2.min.css";

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);

app.config.globalProperties.$query = query;
app.config.globalProperties.global_error_message = 'Something went wrong. Please try again later.';

app.use(VueSweetalert2);
app.use(router);

app.mount("#app");

