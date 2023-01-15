<?php

namespace App\Providers;

use App\Repositories\BoardRepository;
use App\Repositories\ColumnRepository;
use App\Repositories\Concerns\BoardRepositoryInterface;
use App\Repositories\Concerns\ColumnRepositoryInterface;
use App\Repositories\Concerns\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BoardRepositoryInterface::class, BoardRepository::class);
        $this->app->bind(ColumnRepositoryInterface::class, ColumnRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
