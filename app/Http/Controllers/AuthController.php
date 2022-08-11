<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|string',
            'password' => 'required|string|min:6'
        ]);
        $attr['password'] = Hash::make($request->password);

        $user = User::create($attr);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ], "User created");
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Invalid user or password', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
            'user' => auth()->user()
        ], "Successfully logged");
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'User logged out'
        ];
    }
}