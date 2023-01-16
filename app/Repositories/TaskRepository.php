<?php

namespace App\Repositories;

use App\Models\Column;
use App\Models\Task;
use App\Repositories\Concerns\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskRepository implements TaskRepositoryInterface
{

    public function all($filters)
    {
        return Task::query()->status($filters)->date($filters)->board($filters)->get();
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update($id, array $data)
    {
        return Task::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Task::where('id', $id)->delete();
    }

    public function updateColumn($id, $columnId)
    {
        if (!Column::whereId($columnId)->exists()){
            throw new ModelNotFoundException("Column with id $columnId not found!");
        }
        return Task::where('id', $id)->update(['column_id' => $columnId]);
    }
}
