import './bootstrap';
import Vue from 'vue';
import VModal from 'vue-js-modal'

window.bus = new Vue();

Vue.component('icon-add', require('./components/Shared/icons/Add.vue').default);
Vue.component('icon-edit', require('./components/Shared/icons/Edit.vue').default);
Vue.component('icon-delete', require('./components/Shared/icons/Delete.vue').default);
Vue.component('icon-loader', require('./components/Shared/icons/Loader.vue').default);

Vue.component('async-button', require('./components/Shared/AsyncButton.vue').default);
Vue.component('form-input', require('./components/Shared/Input.vue').default);
Vue.component('form-text-area', require('./components/Shared/Textarea.vue').default);
Vue.component('flash-message', require('./components/Shared/FlashMessage.vue').default);
Vue.component('add-board', require('./components/Board/add.vue').default);
Vue.component('kanban-board', require('./screens/KanbanBoard.vue').default);

const filter = (text, length, clamp) => {
    clamp = clamp || '...';
    return text.length > length ? text.slice(0, length) + clamp : text;
};

Vue.filter('truncate', filter);
Vue.use(VModal);

var app = new Vue({
    el: '#app',
    data() {
        return {
            boards: [],
            board: '',
            boardItem: {}
        }
    },
    mounted() {
        this.getBoards();
        bus.$on('board-added', () => {
            this.getBoards();
        })
        bus.$on('column-added', () => {
            this.getBoardData();
        })
        bus.$on('column-deleted', () => {
            this.getBoardData();
        })
    },
    methods: {
        selectBoard() {
            if (!this.board) {
                bus.$emit('flash-message', {text: 'Please Select board before!', type: 'warning'});
                return;
            }
            this.boardItem = {};
            this.getBoardData();
        },
        getBoards() {
            axios.get('boards').then(({data}) => {
                this.boards = data;
            });
        },
        getBoardData() {
            axios.get(`boards/${this.board}`).then(({data}) => {
                this.boardItem = data;
            })
        },
        openAddBoard() {
            this.$modal.show('add-board');
        }
    }
});
