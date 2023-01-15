<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColumnRequest;
use App\Http\Resources\ColumnResource;
use App\Models\Column;
use App\Repositories\Concerns\ColumnRepositoryInterface;
use Illuminate\Http\Request;

class ColumnController extends Controller
{

    public function __construct(protected ColumnRepositoryInterface $columnRepository)
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $boards = $this->columnRepository->all();

        return response()->json(ColumnResource::collection($boards));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\ColumnRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ColumnRequest $request)
    {
        $this->columnRepository->create($request->validated());

        return response()->json(['message' => 'Column Added Successfully!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\ColumnRequest $request
     * @param int $column
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ColumnRequest $request, $column)
    {
        $this->columnRepository->update($column,$request->validated());

        return response()->json(['message' => 'Column Updated Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $column
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($column)
    {
        $this->columnRepository->delete($column);

        return response()->json(['message' => 'Column Deleted Successfully!']);
    }
}
