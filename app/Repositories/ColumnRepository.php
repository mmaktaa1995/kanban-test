<?php

namespace App\Repositories;

use App\Models\Column;
use App\Repositories\Concerns\ColumnRepositoryInterface;

class ColumnRepository implements ColumnRepositoryInterface
{

    public function all()
    {
        return Column::with('tasks')->get();
    }

    public function create(array $data)
    {
        return Column::create($data);
    }

    public function update($id, array $data)
    {
        return Column::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Column::where('id', $id)->delete();
    }
}
