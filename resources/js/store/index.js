import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate'
import auth from './auth'
import { createStore } from 'vuex'
//import Store from './Store'
//import settings from './settings'

Vue.use(Vuex);
export default new Vuex.Store({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
       // Store,
       // settings
    }
})