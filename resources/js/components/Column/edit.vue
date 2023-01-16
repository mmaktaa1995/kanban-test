<template>
    <modal name="edit-column" :scrollable="true" height="auto">
        <div class="modal-title">
            <h5 class="m-0">Edit Column {{column.title}}</h5>
        </div>
        <form @submit.prevent="addColumn" class="modal-content">
            <form-input v-model="form.title" :value="column.title" name="title" type="text" :errors="errors">Title</form-input>
        </form>
        <div class="modal-footer flex justify-end">
            <async-button type="button"
                          @click="addColumn"
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
    name: "editColumn",
    props: ['column'],
    data() {
        return {
            submitted: false,
            form: {
                title: this.column.title,
                board_id: this.column.board_id,
            },
            errors: {}
        }
    },
    methods: {
        addColumn() {
            this.errors = {};
            this.submitted = true;

            axios.put(`/columns/${this.column.id}`, {...this.form}).then(({data}) => {
                bus.$emit('flash-message', {text: data.message, type: 'success'});
                this.$emit('column-updated', {title: this.form.title});
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
            this.$modal.hide('edit-column');
        },
        resetForm() {
            this.form = {
                title: ''
            }
        }
    }
}
</script>

<style scoped>

</style>
