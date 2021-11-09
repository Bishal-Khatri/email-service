import Vuex from 'vuex';
import Vue from 'vue';
import createPersistedState from "vuex-persistedstate";
import {AuthStore} from "./modules/auth.store";

// Load Vuex
Vue.use(Vuex);
// Create store
export default new Vuex.Store({
    modules: {
        auth: AuthStore,
    },
    plugins: [createPersistedState()]
});
