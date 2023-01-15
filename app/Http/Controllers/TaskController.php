<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\Concerns\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\TaskRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TaskRequest $request)
    {
        $this->taskRepository->create($request->validated());

        return response()->json(['message' => 'Task Added Successfully!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskRequest $request, $task)
    {
        $this->taskRepository->update($task,$request->validated());

        return response()->json(['message' => 'Task Updated Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $task
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($task)
    {
        $this->taskRepository->delete($task);

        return response()->json(['message' => 'Task Deleted Successfully!']);
    }

    public function updateColumn($task, $column)
    {
        $this->taskRepository->updateColumn($task,$column);

        return response()->json(['message' => 'Operation Done Successfully!']);
    }
}
