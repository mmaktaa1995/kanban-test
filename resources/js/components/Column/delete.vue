<template>
    <modal name="delete-column" :scrollable="true" v-if="column">
        <div class="modal-title">
            <h5 class="m-0">Delete Column "{{column.title}}"</h5>
        </div>
        <div class="modal-content">
            Are you sure you want to delete this item?
        </div>
        <div class="modal-footer flex justify-end">
            <async-button type="button"
                          @click="addColumn"
                          :loading="submitted"
                          class="button button--state-danger mr-1">
                Delete
            </async-button>
            <button type="button" @click="hide()"
                    class="button">
                Close
            </button>
        </div>
    </modal>
</template>

<script>
export default {
    name: "deleteColumn",
    props: ['column'],
    data() {
        return {
            submitted: false,
        }
    },
    methods: {
        addColumn() {
            this.errors = {};
            this.submitted = true;

            axios.delete(`/columns/${this.column.id}`, {}).then(({data}) => {
                bus.$emit('flash-message', {text: data.message, type: 'success'});
                bus.$emit('column-deleted');
                this.$emit('column-deleted');
                this.hide();
            }).catch((error) => {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors
                }
            }).finally(() => {
                this.submitted = false;
            })
        },
        hide() {
            this.$modal.hide('delete-column');
        },
    }
}
</script>

<style scoped>

</style>
