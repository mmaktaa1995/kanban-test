<?php

namespace App\Repositories\Concerns;

interface TaskRepositoryInterface
{
    public function all($filters);
    public function create(array $data);
    public function update($id, array $data);
    public function updateColumn($id, $columnId);
    public function delete($id);
}
