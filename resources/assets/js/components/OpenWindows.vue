<template>
    <div class="col-sm-4">
        <div class="mod-open-windows">
            <div class="inner">
                <div class="title">
                    Offene Fenster
                </div>
                <ul class="windows-list">
                    <template v-if="openWindows.length > 0">
                        <li v-for="window in openWindows">
                            <strong class="alert">{{ window }}</strong>
                        </li>
                    </template>
                    <template v-else>
                        <li v-for="window in openWindows">
                            <strong class="ok">Alle Fenster geschlossen</strong>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data'],
        computed: {
            openWindows: function() {
                if (this.data && this.data.states && this.data.states.listOpenWindows) {
                    return JSON.parse(this.data.states.listOpenWindows.value);
                }

                return [];
            }
        }
    }
</script>
