<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = ['title', 'description', 'due_date', 'completed', 'user_id'];


    // app/Models/Task.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
