<template>
    <div class="container">
        <h2>{{ board && board.name }}</h2>
        <transition-group name="slide-fade" tag="div" class="columns">
            <div v-for="column in board.columns" :key="column.id" class="column">
                <div class="flex justify-between align-items-center">
                    <h4 class="ml-1">{{ column.title }}</h4>
                    <span>
                        <span>
                            <icon-edit @click="openEditColumn(column)" size="4"
                                       class="text-info cursor-pointer p-1"></icon-edit>
                            <icon-delete @click="openDeleteColumn(column)" size="4"
                                         class="text-danger cursor-pointer p-1"></icon-delete>
                        </span>
                    </span>
                </div>
                <div class="add-card cursor-pointer" @click="openAddTask(column)">
                    <icon-add size="12"></icon-add>
                </div>
                <draggable :data-column="column.id" class="cards" @end="onMoveCallback" :list="column.tasks"
                           group="columns"
                           ghost-class="ghost">
                    <div class="card" :data-task="task.id" v-for="task in column.tasks" :key="'card-' + task.id"
                         @click="openEditTask(task)">
                        <div class="card-title">
                            <div class="flex justify-between align-items-center">
                                <span>{{ task.title }}</span>
                                <span @click="openAddColumn">
                                    <icon-delete @click="openDeleteTask($event, task)" size="4"
                                                 class="text-danger cursor-pointer"></icon-delete>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="m-0">{{ task.description | truncate(100) }}</p>
                        </div>
                    </div>
                </draggable>
            </div>
            <div class="column max-h-100" key="add-column">
                <div class="flex justify-between align-items-center">
                    <h4 class="ml-1">Add Column</h4>
                    <span @click="openAddColumn">
                        <icon-add size="4" class="text-info cursor-pointer"></icon-add>
                    </span>
                </div>
            </div>
        </transition-group>

        <add-column :board="board"></add-column>
        <delete-column @column-deleted="columnDeleted" :column="selectedColumn" v-if="selectedColumn"></delete-column>
        <edit-column @column-updated="columnUpdated" :column="selectedColumn" v-if="selectedColumn"></edit-column>

        <add-task @task-added="taskAdded" :column="selectedColumn"></add-task>
        <delete-task @task-deleted="taskDeleted" :task="selectedTask" v-if="selectedTask"></delete-task>
        <edit-task @task-updated="taskUpdated" :task="selectedTask" v-if="selectedTask"></edit-task>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import AddColumn from "../components/Column/add";
import DeleteColumn from "../components/Column/delete";
import EditColumn from "../components/Column/edit";
import AddTask from "../components/Task/add";
import EditTask from "../components/Task/edit";
import DeleteTask from "../components/Task/delete";

export default {
    components: {
        DeleteTask,
        EditTask,
        AddTask,
        EditColumn,
        DeleteColumn,
        AddColumn,
        draggable,
    },
    props: ['board'],
    data() {
        return {
            initiated: false,
            selectedColumn: null,
            selectedTask: null,
            tasksState: []
        };
    },
    mounted() {
        this.board.columns.forEach(column => {
            this.tasksState = [...this.tasksState, ...column.tasks];
        });
    },
    methods: {
        log: function (task) {
            // console.log(task)
            return;
            if (task.added) {
                const newColumnIndex = task.added.newIndex;
                const column = this.board.columns[newColumnIndex];
                if (task.added.element.column_id !== column.id) {
                    axios.post(`tasks/${task.added.element.id}/${column.id}`).then(({data}) => {
                        bus.$emit('flash-message', {text: data.message, type: 'success'});
                        const taskIndex = column.tasks.findIndex(_ => _.id === task.added.element.id);
                        column.tasks[taskIndex].column_id = column.id;
                    });
                }
            }
            if (task.removed) {
                const oldColumnIndex = task.removed.oldIndex;
                const column = this.board.columns[oldColumnIndex];
                if (task.removed.element.column_id !== column.id) {
                    axios.post(`tasks/${task.removed.element.id}/${column.id}`).then(({data}) => {
                        bus.$emit('flash-message', {text: data.message, type: 'success'});
                        const taskIndex = column.tasks.findIndex(_ => _.id === task.removed.element.id);
                        column.tasks[taskIndex].column_id = column.id;
                    });
                }
            }
        },
        onMoveCallback: function (event) {
            const taskId = +event.item.dataset.task;
            const columnId = +event.to.dataset.column;
            const columnIndex = this.board.columns.findIndex(_ => _.id === columnId);
            const column = this.board.columns[columnIndex];
            const task = this.tasksState.find(_ => _.id === taskId);

            if (task.column_id !== columnId) {
                axios.post(`tasks/${taskId}/${columnId}`).then(({data}) => {
                    bus.$emit('flash-message', {text: data.message, type: 'success'});
                    const taskIndex = column.tasks.findIndex(_ => _.id === taskId);
                    column.tasks[taskIndex].column_id = columnId;
                    task.column_id = columnId;
                });
            }
        },
        openAddColumn() {
            this.$modal.show('add-column');
        },
        openDeleteColumn(column) {
            this.selectedColumn = {...column};
            setTimeout(() => this.$modal.show('delete-column'));
        },
        openEditColumn(column) {
            this.selectedColumn = null;
            setTimeout(() => this.selectedColumn = {...column});
            setTimeout(() => this.$modal.show('edit-column'), 100);
        },
        columnDeleted() {
            this.selectedColumn = null;
        },
        columnUpdated(data) {
            const index = this.board.columns.findIndex(_ => _.id === this.selectedColumn.id);
            this.board.columns[index].title = data.title;
            this.selectedColumn = null;
        },
        openAddTask(column) {
            this.selectedColumn = column;
            this.$modal.show('add-task');
        },
        openEditTask(task) {
            this.selectedTask = null;
            setTimeout(() => this.selectedTask = {...task});
            setTimeout(() => this.$modal.show('edit-task'), 100);
        },
        taskAdded(task) {
            const index = this.board.columns.findIndex(_ => _.id === this.selectedColumn.id);
            this.board.columns[index].tasks.push(task);
            this.selectedColumn = null;
        },
        taskUpdated(task) {
            const index = this.board.columns.findIndex(_ => _.id === this.selectedTask.column_id);
            const taskIndex = this.board.columns[index].tasks.findIndex(_ => _.id === task.id);
            this.board.columns[index].tasks[taskIndex] = {...task};
            this.selectedTask = null;
        },
        taskDeleted(task) {
            const index = this.board.columns.findIndex(_ => _.id === this.selectedTask.column_id);
            this.board.columns[index].tasks = this.board.columns[index].tasks.filter(_ => _.id !== task.id)
            this.selectedTask = null;
        },
        openDeleteTask($event, task) {
            $event.stopPropagation();
            this.selectedTask = {...task};
            setTimeout(() => this.$modal.show('delete-task'));
        },
    }

};
</script>
<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.5s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>
