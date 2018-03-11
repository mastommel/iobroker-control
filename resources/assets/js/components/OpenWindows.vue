<template>
    <div class="mod-open-windows">
        <div class="inner">
            <div class="title">
                <ul>
                    <li v-for="window in openWindows">
                        <strong class="alert">{{ window.name }}</strong>
                    </li>
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
                const open = [];
                if (this.data) {
                    console.log(this.data);
                    for (let window in this.data) {

                        for (let state in this.data[window]) {
                            if (this.data[window][state].name === 'STATE' && this.data[window][state].value) {
                                open.push(this.data[window]);
                            }
                        }
                    }

                }
                console.log(open);
                return open;
            }
        }
    }
</script>
