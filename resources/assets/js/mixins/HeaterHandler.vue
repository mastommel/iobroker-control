<script>
    export default {
        data() {
            return {
                tempUpdateTimeout: null
            };
        },
        methods: {
            updateTemperature(data) {
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
    }
</script>
