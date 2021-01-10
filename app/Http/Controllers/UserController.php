<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;

class UserController extends Controller
{
  public function authenticate(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');
    try {
      if (!$token = JWTAuth::attempt($credentials)) {
        return response()->json(['error' => 'invalid_credentials'], 400);
      }
      $user = User::where('email', $credentials['email'])->first();
    } catch (JWTException $e) {
      return response()->json(['error' => 'could_not_create_token', 'extra' => $e->getMessage()], 500);
    }
    return response()->json(compact('token', 'user'));
  }

  public function getAuthUser()
  {
    $user = JWTAuth::parseToken()->authenticate();
    return response()->json(compact('user'));
  }

  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 400);
    }

    $user = User::create([
      'name' => $request->get('name'),
      'email' => $request->get('email'),
      'password' => Hash::make($request->get('password')),
    ]);

    $token = JWTAuth::fromUser($user);

    return response()->json(compact('user', 'token'), 201);
  }

  public function all() {
    $Users = User::orderBy('id')->get();
    return response()->json($Users);
  }

  public function inactiveUsers(Request $request) {
    $request->validate([
      'users' => 'required|array'
    ]);
    User::whereIn('id', $request->users)->update(['status' => false]);
    $Users = User::whereIn('id', $request->users)->get();
    return response()->json($Users);
  }

  public function generateRandomUsers() {
    $usersRandom = [];
    for($i = 0; $i < 10;$i++) {
      $usersRandom[] = [
        'name' => Str::random(10),
        'email' => Str::random(10).'@email.com',
        'password' => Hash::make('Temp123'),
        'phone' => Str::random(10),
        'status' => true
      ];
    }

    User::insert($usersRandom);
    $Users = User::orderBy('id', 'desc')->take(count($usersRandom))->get();

    return response()->json($Users);
  }
}
