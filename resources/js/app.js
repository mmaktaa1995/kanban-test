import './bootstrap';
import Vue from 'vue';

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
        bus.$on('board-added', (id) => {
            this.getBoards();
            this.board = id;
            this.getBoardData();
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
        exportDB() {
            axios.post('export-db').then(({data}) => {
                bus.$emit('flash-message', {text: data.message, type: 'success'});
            });
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
