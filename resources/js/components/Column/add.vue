<template>
    <modal name="add-column" :scrollable="true">
        <div class="modal-title">
            <h5 class="m-0">Add Column</h5>
        </div>
        <form @submit.prevent="addColumn" class="modal-content">
            <form-input v-model="form.title" name="title" type="text" :errors="errors">Title</form-input>
        </form>
        <div class="modal-footer flex justify-end">
            <async-button type="button"
                          @click="addColumn"
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
    name: "addColumn",
    props: ['board'],
    data() {
        return {
            submitted: false,
            form: {
                title: ''
            },
            errors: {}
        }
    },
    methods: {
        addColumn() {
            this.errors = {};
            this.submitted = true;

            axios.post(`/columns`, {...this.form, board_id: this.board.id}).then(({data}) => {
                bus.$emit('flash-message', {text: data.message, type: 'success'});
                bus.$emit('column-added');
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
            this.$modal.hide('add-column');
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
