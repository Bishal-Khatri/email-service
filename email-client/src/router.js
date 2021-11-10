import Vue from "vue";
import VueRouter from "vue-router";
import store from "./store";
import Outbox from "./pages/Outbox";
import Login from "./pages/Login";
import Register from "./pages/Register";
import Compose from "./pages/Compose";

Vue.use(VueRouter);

const routes = [
    {
        path: "/compose",
        name: "Compose",
        component: Compose,
        meta: { requiresAuth: true },
    },
    {
        path: "/outbox",
        name: "Outbox",
        component: Outbox,
        meta: { requiresAuth: true },
    },
    {
        path: "/",
        name: "Home",
        component: Outbox,
        meta: { requiresAuth: true },
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: { guest: true },
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
        meta: { guest: true },
    },
];

const router = new VueRouter({
    // mode: "history",
    // base: process.env.BASE_URL,
    routes,
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (store.getters['auth/isAuthenticated']) {
            next();
            return;
        }
        next("/login");
    } else {
        next();
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.guest)) {
        if (store.getters['auth/isAuthenticated']) {
            next("/");
            return;
        }
        next();
    } else {
        next();
    }
});

export default router;
