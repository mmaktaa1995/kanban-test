<?php

namespace App\Repositories\Concerns;

interface BoardRepositoryInterface
{
    public function all();
    public function create(array $data);
}
