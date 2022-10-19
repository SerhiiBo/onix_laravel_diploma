<?php

namespace App\Http\Controllers\Api;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $createdUser = User::create($request->validated());
        $token = $createdUser->createToken('auth_token')->plainTextToken;
        event(new UserRegistered($createdUser));
        return response()->json([
            'user' => new UserResource($createdUser),
            'access_token' => $token,
        ]);
    }

    public function login(Request $request)
    {
        $loginFields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $loginFields['email'])->first();

        if (!$user) {
            return response([
                'message' => 'Такого пользователя нет в базе',
            ], 401);
        } elseif ($user->password !== $loginFields['password']) {
            return response([
                'message' => 'Логин и пароль не соответствуют',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Authentication success',
            'user' => $user,
            'access_token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return [
            'message' => 'You have successfully logged out!'
        ];
    }
}
