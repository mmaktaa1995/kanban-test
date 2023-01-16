<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'column_id'];

    public function column()
    {
        return $this->belongsTo(Column::class);
    }

    public function scopeStatus($query, $filters)
    {
        return $query->when(isset($filters['status']), function ($query) use ($filters) {
            if ($filters['status'] == 0) {
                $query->onlyTrashed();
            }
        })->when(!isset($filters['status']), function ($query) use ($filters) {
            $query->withTrashed();
        });
    }

    public function scopeDate($query, $filters)
    {
        return $query->when(isset($filters['creation_date']), function ($query) use ($filters) {
            $query->whereDate('tasks.created_at', DB::raw("'{$filters['creation_date']}'"));
        });
    }

    public function scopeBoard($query, $filters)
    {
        return $query->when(isset($filters['board']), function ($query) use ($filters) {
            $query->leftJoin('columns', 'columns.id', 'tasks.column_id')
                ->where('columns.board_id', $filters['board'])
            ->select('tasks.*');
        });
    }
}
