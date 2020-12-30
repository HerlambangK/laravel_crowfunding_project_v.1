require("./bootstrap");
window.Vue = require("vue");
// Vue.component(
//     "example-component",
//     require("./components/ExampleComponent.vue").default
// );
// Vue.component("app", require("./views/Home.vue").default);

import Vue from "vue";
import Router from "./router";
import App from "./App.vue";
import Vuetify from "./plugins/vuetify";
import "./bootstrap";

const app = new Vue({
    el: "#app",
    router: Router,
    vuetify: Vuetify,
    components: {
        App
    }
});
