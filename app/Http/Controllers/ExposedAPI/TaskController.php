<?php

namespace App\Http\Controllers\ExposedAPI;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\Concerns\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskController
{

    public function __construct(protected TaskRepositoryInterface $taskRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $boards = $this->taskRepository->all($request->all());

        return response()->json(TaskResource::collection($boards));
    }
}
