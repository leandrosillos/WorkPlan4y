<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 
        'user_id', 
        'title', 
        'description', 
        'status', 
        'due_date'
    ];

    public function projects()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
