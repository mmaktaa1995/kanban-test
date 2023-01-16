<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardRequest;
use App\Http\Resources\BoardResource;
use App\Models\Board;
use App\Repositories\Concerns\BoardRepositoryInterface;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function __construct(protected BoardRepositoryInterface $boardRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $boards = $this->boardRepository->all();

        return response()->json(BoardResource::collection($boards));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\BoardRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BoardRequest $request)
    {
        $this->boardRepository->create($request->validated());

        return response()->json(['message' => 'Board Added Successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board  $board
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Board $board)
    {
        $board->load('columns.tasks');
        return response()->json(BoardResource::make($board));
    }
}
