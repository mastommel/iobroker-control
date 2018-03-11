<template>
    <div class="mod-heater">
        <div class="inner">
            <div class="title">
                {{ data.name }}
            </div>
            <div class="row no-gutters">
                <div class="col-sm-6">
                    <div class="row no-gutters real-temperature-wrap">
                        <div class="col-sm-12">
                            <div class="temperature-radius">
                                <span class="real-temperature">{{ data.states.ACTUAL_TEMPERATURE.value }}°</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <span v-show="!data.states.LOW_BAT.value">&nbsp;</span>
                            <i v-show="data.states.LOW_BAT.value" class="warning fas fa-battery-quarter"></i>
                        </div>
                        <div class="col-sm-12">
                            <i v-show="data.states.SET_POINT_MODE.value === 0" class="fas fa-clock"></i>
                            <i v-show="data.states.SET_POINT_MODE.value === 1" class="far fa-circle"></i>
                            <i v-show="data.states.WINDOW_STATE.value" class="fas fa-window-close"></i>
                            <i v-show="data.states.BOOST_MODE.value" class="fab fa-hotjar"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row no-gutters text-center set-temperature-wrap">
                        <div class="col-sm-12">
                            <span class="arrow-up bigger">
                                <i @click="temperatureUp()" class="fas fa-angle-up temperature-action"></i>
                            </span>
                        </div>
                        <div class="col-sm-12">
                            <strong class="set-temperature bigger" :class="{ 'no-ack': !tempAcknowledged }">
                                {{ data.states.SET_POINT_TEMPERATURE.value }}°
                            </strong>
                        </div>
                        <div class="col-sm-12 ">
                            <span class="arrow-down bigger">
                                <i @click="temperatureDown()" class="fas fa-angle-down temperature-action"></i>
                            </span>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        computed: {
            tempAcknowledged: function () {
                return this.data.states.SET_POINT_TEMPERATURE.ack;
            }
        },
        methods: {
            temperatureUp: function () {
                this.$emit('temperaturechange', {
                    stateId: this.data.states.SET_POINT_TEMPERATURE.id,
                    temperature: this.data.states.SET_POINT_TEMPERATURE.value + 0.5
                });
            },
            temperatureDown: function () {
                this.$emit('temperaturechange', {
                    stateId: this.data.states.SET_POINT_TEMPERATURE.id,
                    temperature: this.data.states.SET_POINT_TEMPERATURE.value - 0.5
                });
            }
        }
    }
</script>
