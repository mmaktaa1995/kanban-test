<?php

use App\Http\Controllers\{BoardController,
    ColumnController,
    ExposedAPI\TaskController as ExposedTaskController,
    MainController,
    TaskController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/list-cards', [ExposedTaskController::class, 'index'])
    ->middleware('check_access_token')
    ->name('tasks_exposed_api');

Route::resource('boards', BoardController::class)->only(['index', 'store', 'show']);
Route::resource('columns', ColumnController::class)->except(['edit', 'create', 'show']);
Route::resource('tasks', TaskController::class)->except(['edit', 'create', 'show']);
Route::post('tasks/{task}/{column}', [TaskController::class, 'updateColumn'])->name('tasks.update_column');
Route::post('export-db', [MainController::class, 'exportDB'])->name(
    'export_db'
);

