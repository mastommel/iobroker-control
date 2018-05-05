
require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

// Pages
import Dashboard from './pages/Dashboard.vue';
import Upstairs from './pages/Upstairs.vue';
import Downstairs from './pages/Downstairs.vue';

// Mixins
import APIClient from './mixins/APIClient.vue';
import HeaterHandler from './mixins/HeaterHandler.vue';
import LaravelEchoService from './mixins/LaravelEchoService.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        { path: '/', component: Dashboard },
        { path: '/upstairs', component: Upstairs },
        { path: '/downstairs', component: Downstairs },
    ]
});

new Vue({
    el: '#app',
    router,
    components: {
        'dashboard': Dashboard
    },
    mixins: [
        APIClient,
        LaravelEchoService,
        HeaterHandler,
    ],
    data() {
        return {
            deviceMapping: {},
            heating: [],
            windows: [],
            virtuals: []
        };
    },
    created() {
        this.refreshData();
        setInterval(this.refreshData, 1000*60*3);
        this.initLaravelEcho();
    }
});
