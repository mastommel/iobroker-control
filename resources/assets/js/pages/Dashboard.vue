<template>
    <div class="mod-dashboard">
        <div class="container-fluid">

            <div class="row">
                <open-windows :data="openWindows"></open-windows>
            </div>

            <div class="row">
                <div v-for="heater in heating" class="col-sm-2">
                    <heater :data="heater" v-on:temperaturechange="forwardTemperatureChange"></heater>
                </div>
            </div>

            <div class="row">
                <div v-for="window in windows" class="col-sm-2">
                    <window :data="window"></window>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import Heater from '../components/Heater.vue';
    import Window from'../components/Window.vue';
    import OpenWindows from '../components/OpenWindows.vue';

    export default {
        props: [
            'heating',
            'windows',
            'virtuals',
        ],
        components: {
            'heater': Heater,
            'window': Window,
            'open-windows': OpenWindows
        },
        computed: {
            openWindows: function () {
                return this.virtuals['open_windows'] || '';
            }
        },
        methods: {
            forwardTemperatureChange(data) {
                this.$emit('temperaturechange', data);
            }
        }
    }
</script>
