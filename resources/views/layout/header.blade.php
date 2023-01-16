<nav class="flex justify-between">
    <div class="logo">
        <h3 class="text-white m-0 inline-block">Kanban Test</h3>
        <button class="button ml-1 inline-block" @click="openAddBoard">Add Board</button>
    </div>
    <div class="menu">
        <label for="board" class="text-white mr-1">Select Board</label>
        <select name="board" id="board" v-model="board" class="form-control inline-block w-250">
            <option value="">Select Board</option>
            <option v-for="board in boards" :value="board.id">@{{board.name}}</option>
        </select>
        <button type="button" @click="selectBoard" class="button button--state-info">Select</button>
    </div>
</nav>
