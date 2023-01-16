<template>
    <modal name="add-board" :scrollable="true">
        <div class="modal-title">
            <h5 class="m-0">Add Board</h5>
        </div>
        <form @submit.prevent="addBoard" class="modal-content">
            <!--            <div class="">-->
            <!--                <label for="name" class="">Name</label>-->
            <!--                <input type="text" id="name" v-model="form.name" class="form-control">-->
            <!--                <br>-->
            <!--                <small class="text-danger" v-if="errors && errors.name">{{ errors.name[0] }}</small>-->
            <!--            </div>-->
            <form-input v-model="form.name" name="name" type="text" :errors="errors">Name</form-input>
        </form>
        <div class="modal-footer flex justify-end">
            <async-button type="button"
                          @click="addBoard"
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
    name: "addBoard",
    data() {
        return {
            submitted: false,
            form: {
                name: ''
            },
            errors: {}
        }
    },
    methods: {
        addBoard() {
            this.errors = {};
            this.submitted = true;

            axios.post(`/boards`, {...this.form}).then(({data}) => {
                bus.$emit('flash-message', {text: data.message, type: 'success'});
                bus.$emit('board-added');
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
            this.$modal.hide('add-board');
        },
        resetForm() {
            this.form = {
                name: ''
            }
        }
    }
}
</script>

<style scoped>

</style>
