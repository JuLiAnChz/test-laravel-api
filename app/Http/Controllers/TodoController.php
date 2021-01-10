<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\Todo;
use App\Enums\TodoStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
  public function store(Request $request) {
    $request->validate([
      'title' => 'required'
    ]);

    $user = JWTAuth::parseToken()->authenticate();

    DB::beginTransaction();

    try {
      $todo = $user->todos()->save(new Todo([
        'todo_status_id' => TodoStatusEnum::PENDING,
        'user_id' => $user->id,
        'title' => $request->title
      ]));
      DB::commit();
      return response()->json($user->todos()->with('status')->find($todo->id), 201);
    } catch(\Exception $e) {
      DB::rollback();
      return response()->json(['message' => $e->getMessage()], 500);
    }
  }

  public function update($todo_id, Request $request) {
    $request->validate([
      'title' => 'required|string',
      'status' => 'required|string|exists:todo_status,id'
    ]);

    if (!$todo_id) {
      return response()->json(['message' => 'specify_query_parameter'], 500);
    }

    $user = JWTAuth::parseToken()->authenticate();

    $todo = $user->todos()->find($todo_id);

    if(!$todo) {
      return response()->json(['message' => 'user_todo_invalid'], 500);
    }

    $todo->title = $request->title;
    $todo->todo_status_id = $request->status;
    $todo->save();

    return response()->json($user->todos()->with('status')->find($todo_id));
  }

  public function index() {
    $user = JWTAuth::parseToken()->authenticate();
    return response()->json($user->todos()->where('todo_status_id', '!=', TodoStatusEnum::DELETED)->with('status')->get());
  }
}
