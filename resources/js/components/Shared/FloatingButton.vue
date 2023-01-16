<template>
    <button v-bind="$attrs" v-on="$listeners" :type="type" class="button button--floating bottom-right" :disabled="disabled">
            <slot></slot>
    </button>
</template>

<script>

export default {
    name: 'FloatingButton',

    props: {
        type: {
            default: 'button',
        },
        disabled: {},
    },
    mounted(){
    }
};
</script>
