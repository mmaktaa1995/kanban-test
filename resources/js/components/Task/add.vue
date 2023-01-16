<template>
    <modal name="add-task" :scrollable="true">
        <div class="modal-title">
            <h5 class="m-0">Add Task</h5>
        </div>
        <form @submit.prevent="addTask" class="modal-content">
            <form-input v-model="form.title" class="w-full" name="title" type="text" :errors="errors">Title</form-input>
            <form-text-area v-model="form.description" class="w-full" name="description" type="text" :errors="errors">Description</form-text-area>
        </form>
        <div class="modal-footer flex justify-end">
            <async-button type="button"
                          @click="addTask"
                          :loading="submitted"
                          class="button button--state-success mr-1">
                Submit
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
    name: "addTask",
    props: ['column'],
    data() {
        return {
            submitted: false,
            form: {
                title: '',
                description: '',
            },
            errors: {}
        }
    },
    methods: {
        addTask() {
            this.errors = {};
            this.submitted = true;

            axios.post(`/tasks`, {...this.form, column_id: this.column.id}).then(({data}) => {
                bus.$emit('flash-message', {text: data.message, type: 'success'});
                this.$emit('task-added', data.task);
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
            this.$modal.hide('add-task');
        },
        resetForm() {
            this.form = {
                title: '',
                description: '',
            }
        }
    }
}
</script>

<style scoped>

</style>
