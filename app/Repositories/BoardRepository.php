<?php

namespace App\Repositories;

use App\Models\Board;
use App\Repositories\Concerns\BoardRepositoryInterface;

class BoardRepository implements BoardRepositoryInterface
{

    public function all()
    {
        return Board::all();
    }

    public function create(array $data)
    {
        return Board::create($data);
    }
}
