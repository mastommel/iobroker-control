
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('heater', require('./components/Heater.vue'));
Vue.component('window', require('./components/Window.vue'));
Vue.component('open-windows', require('./components/OpenWindows.vue'));

const app = new Vue({
    el: '#app',
    data: {
        devices: [],
        heating: [],
        windows: [],
        tempUpdateTimeout: null
    },
    methods: {
        refreshData: function () {
            axios.get('/api/devices')
                .then(response => {
                    if (response.data.heating) {
                        for (let id in response.data.heating) {
                            this.setAcknowledged(response.data.heating[id].states);
                        }
                        this.heating = response.data.heating;
                    }
                    if (response.data.windows) {
                        this.windows = response.data.windows;
                    }
                });
        },
        updateTemperature: function (data) {
            this.updateLocalSetPointTemperature(data.stateId, data.temperature);
            if (this.tempUpdateTimeout) {
                window.clearTimeout(this.tempUpdateTimeout);
            }
            this.tempUpdateTimeout = setTimeout(function () {
                axios.post('/api/state/update', {
                    state: data.stateId,
                    value: data.temperature
                });
            }, 1000*2);
        },
        setAcknowledged: function (states) {
            for (let id in states) {
                states[id].ack = true;
            }
        },
        updateLocalSetPointTemperature(stateId, value) {
            for (let id in this.heating) {
                for (let state in this.heating[id].states) {
                    if (this.heating[id].states[state].id === stateId) {
                        this.heating[id].states[state].value = value;
                        this.heating[id].states[state].ack = false;
                    }
                }
            }
        }
    },
    created() {
        this.refreshData();
        setInterval(this.refreshData, 1000*60*3);

        Echo.channel('state.updated').listen('IoBrokerStateFound', e => {
            let stateIdParts = e.stateId.split('.');
            let deviceId = stateIdParts[0] + '.' + stateIdParts[1] + '.' + stateIdParts[2];

            if (this.heating.hasOwnProperty(deviceId)) {
                if (this.heating[deviceId].states.hasOwnProperty(stateIdParts[4])) {
                        this.heating[deviceId].states[stateIdParts[4]].value = e.value;
                        this.heating[deviceId].states[stateIdParts[4]].ack = true;
                }
            }

            if (this.windows.hasOwnProperty(deviceId)) {
                if (this.windows[deviceId].states.hasOwnProperty(stateIdParts[4])) {
                    this.windows[deviceId].states[stateIdParts[4]].value = e.value;
                }
            }
        });
    }
});
