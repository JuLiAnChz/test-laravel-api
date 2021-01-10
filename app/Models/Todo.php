<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
  use HasFactory;

  protected $table = 'todo';
  protected $fillable = ['todo_status_id', 'user_id', 'title'];

  public function status() {
    return $this->belongsTo(TodoStatus::class, 'todo_status_id', 'id');
  }

  public function user() {
    return $this->belongsTo(User::class);
  }
}
