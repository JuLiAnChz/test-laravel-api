<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoStatus extends Model
{
    use HasFactory;

    protected $table = 'todo_status';
    protected $fillable = ['title'];
    public $incrementing = false;
    public $keyType = 'string';

    public function todos() {
      return $this->hasMany(Todo::class);
    }
}
