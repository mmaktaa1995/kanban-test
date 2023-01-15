<?php

namespace App\Repositories\Concerns;

interface ColumnRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
