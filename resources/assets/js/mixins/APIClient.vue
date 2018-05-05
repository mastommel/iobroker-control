<script>
    export default {
        methods: {
            refreshData() {
                window.axios.get('/api/devices')
                    .then(response => {
                        if (response.data.heating) {
                            for (let id in response.data.heating) {
                                this._setAcknowledged(response.data.heating[id].states);
                            }

                            this.heating = response.data.heating;
                            this._updateDeviceMapping(this.heating, 'heating');
                        }

                        if (response.data.windows) {
                            this.windows = response.data.windows;
                            this._updateDeviceMapping(this.windows, 'windows');
                        }

                        if (response.data.virtual_devices) {
                            this.virtuals = response.data.virtual_devices;
                            this._updateDeviceMapping(this.virtuals, 'virtuals');
                        }
                        console.log(this.deviceMapping);
                    });
            },

            _setAcknowledged(states) {
                for (let id in states) {
                    states[id].ack = true;
                }
            },

            _updateDeviceMapping(devices, type) {
                for (let systemName in devices) {
                    if (devices.hasOwnProperty(systemName) && !this.deviceMapping.hasOwnProperty(devices[systemName].id)) {
                        this.deviceMapping[devices[systemName].id] = {
                            systemName,
                            type
                        };
                    }
                }
            }
        }
    }
</script>
