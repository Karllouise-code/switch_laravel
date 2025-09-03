import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import VueSweetalert2 from "vue-sweetalert2";
import App from "./App.vue";
import routes from "./routes.js";

import "bootstrap/dist/js/bootstrap.bundle.min.js";

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);


app.use(VueSweetalert2);
app.use(router);

app.mount("#app");

