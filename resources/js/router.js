import Vue from "vue";
import Router from "vue-router";
import Home from "./views/Home.vue";
import Donations from "./views/Donations.vue";

Vue.use(Router);

const router = new Router({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
            alias: "/home",
            component: Home
            // components: () => import("./views/Home.vue")
        },
        {
            path: "/donations",
            name: "donations",
            alias: "/donations",
            component: Donations
        },
        {
            path: "*",
            redirect: "/"
        }
    ]
});

export default router;
