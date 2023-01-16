<template>
    <div class="">
        <label :for="name" class="form-label">
            <slot></slot>
        </label>
        <input :disabled="disabled" :type="type" :id="name"
               :name="name"
               :value="value"
               @input="handleChange"
               class="form-control">
        <small class="text-danger" v-if="name && errors && errors[name]">{{ errors[name][0] }}</small>
    </div>
</template>

<script>

export default {
    name: 'Input',
    props: ['type', 'disabled', 'name', 'errors', 'value'],
    mounted() {
    },
    methods: {
        handleChange(event) {
            this.$emit('input', event.target.value)
        }
    }
};
</script>
