<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $query->when($filters['status'], function ($query) use ($filters) {
            if ($filters['status'] == 0) {
                $query->onlyTrashed();
            }
        })->when(!$filters['status'], function ($query) use ($filters) {
            $query->withTrashed();
        });
    }

    public function scopeDate($query, $filters)
    {
        return $query->when($filters['creation_date'], function ($query) use ($filters) {
                $query->whereDate('created_at', $filters['creation_date']);
        });
    }
}
