<template>
    <modal name="delete-task" :scrollable="true" v-if="task">
        <div class="modal-title">
            <h5 class="m-0">Delete Task "{{task.title}}"</h5>
        </div>
        <div class="modal-content">
            Are you sure you want to delete this item?
        </div>
        <div class="modal-footer flex justify-end">
            <async-button type="button"
                          @click="addTask"
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
    name: "deleteTask",
    props: ['task'],
    data() {
        return {
            submitted: false,
        }
    },
    methods: {
        addTask() {
            this.errors = {};
            this.submitted = true;

            axios.delete(`/tasks/${this.task.id}`, {}).then(({data}) => {
                bus.$emit('flash-message', {text: data.message, type: 'success'});
                this.$emit('task-deleted', this.task);
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
            this.$modal.hide('delete-task');
        },
    }
}
</script>

<style scoped>

</style>
