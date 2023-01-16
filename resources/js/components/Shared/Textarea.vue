<template>
    <div class="">
        <label :for="name" class="form-label">
            <slot></slot>
        </label>
        <textarea :disabled="disabled" :id="name"
                  :name="name"
                  :value="value"
                  rows="5"
                  @input="handleChange"
                  class="form-control"></textarea>
        <small class="text-danger" v-if="name && errors && errors[name]">{{ errors[name][0] }}</small>
    </div>
</template>

<script>

export default {
    name: 'Textarea',
    props: ['disabled', 'name', 'errors', 'value'],
    mounted() {
    },
    methods: {
        handleChange(event) {
            this.$emit('input', event.target.value)
        }
    }
};
</script>
