<template>
    <div class="mod-window">
        <div class="inner">
            <div class="title">
                {{ data.name }}
            </div>
            <div class="row no-gutters">
                <div class="col-md-12">
                    <i v-show="!data.states.STATE.value" class="fas fa-check"></i>
                    <i v-show="data.states.STATE.value" class="fas fa-times"></i>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['data']
    }
</script>
