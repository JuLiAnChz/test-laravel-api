<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

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
}
