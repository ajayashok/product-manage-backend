<?php

namespace App\Repositories;

use App\Contracts\AuthRepoInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepoInterface {

    // Register User
    public function register(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // Login User
    public function login(array $data) {
        $response = [];
        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            $response = [
                'token' => $token,
                'user' => $user,
            ];
        }
        return $response;
    }

    // Logout User
    public function logout() {
        request()->user()->currentAccessToken()->delete();
        return true;
    }
}
