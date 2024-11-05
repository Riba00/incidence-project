<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidence extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'todo' => 'To Do',
            'doing' => 'Doing',
            'done' => 'Done',
            default => ucfirst($this->status),
        };
    }

    
}
