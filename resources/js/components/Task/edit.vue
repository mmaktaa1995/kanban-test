<template>
    <modal name="edit-task" :scrollable="true" height="auto">
        <div class="modal-title">
            <h5 class="m-0">Edit Task {{task.title}}</h5>
        </div>
        <form @submit.prevent="addTask" class="modal-content">
            <form-input v-model="form.title" :value="task.title" name="title" type="text" :errors="errors">Title</form-input>
            <form-text-area v-model="form.description" class="w-full" name="description" type="text" :errors="errors">Description</form-text-area>
        </form>
        <div class="modal-footer flex justify-end">
            <async-button type="button"
                          @click="addTask"
                          :loading="submitted"
                          class="button button--state-success mr-1">
                Update
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
    name: "editTask",
    props: ['task'],
    data() {
        return {
            submitted: false,
            form: {
                title: {...this.task}.title,
                description: {...this.task}.description,
                column_id: {...this.task}.column_id,
            },
            errors: {}
        }
    },
    methods: {
        addTask() {
            this.errors = {};
            this.submitted = true;

            axios.put(`/tasks/${this.task.id}`, {...this.form}).then(({data}) => {
                bus.$emit('flash-message', {text: data.message, type: 'success'});
                this.$emit('task-updated', {...this.task, ...this.form});
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
            this.resetForm();
            this.$modal.hide('edit-task');
        },
        resetForm() {
            this.form = {
                title: '',
                description: '',
            }
        }
    },
}
</script>

<style scoped>

</style>
