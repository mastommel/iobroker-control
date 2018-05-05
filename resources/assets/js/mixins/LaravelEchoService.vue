<script>
    export default {
        methods: {
            initLaravelEcho() {
                window.Echo.channel('state.updated').listen('IoBrokerStateFound', e => {
                    const stateIdParts = e.stateId.split('.');
                    const deviceId = stateIdParts[0] + '.' + stateIdParts[1] + '.' + stateIdParts[2];

                    console.log(e);

                    if (this.deviceMapping.hasOwnProperty(deviceId)) {
                        const type = this.deviceMapping[deviceId].type;
                        const systemName = this.deviceMapping[deviceId].systemName;

                        if (this[type] && this[type][systemName] && this[type][systemName].hasOwnProperty('states')) {
                            if (this[type][systemName].states.hasOwnProperty(stateIdParts[4])) {
                                this._updateState(type, systemName, stateIdParts[4], e.value);
                            } else if (this[type][systemName].states.hasOwnProperty(stateIdParts[3])) {
                                this._updateState(type, systemName, stateIdParts[3], e.value);
                            }

                        }
                    }
                });
            },

            _updateState(type, systemName, state, value) {
                this[type][systemName].states[state].value = value;
                this[type][systemName].states[state].ack = true;
            }
        }
    }
</script>
