<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function register(array $data): User
    {
        $user = User::create([
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'birth_date' => $data['birth_date'] ?? null,
            'registered_at' => now(),
        ]);
        $user->tokens()->delete();

        return $user;
    }

    public function login(array $data): ?User
    {
        $login = $data['login'] ?? null;
        $password = $data['password'] ?? null;

        if (! $login || ! $password) {
            return null;
        }

        $user = User::where('login', $login)->first();
        if (! $user || ! Hash::check($password, $user->password)) {
            return null;
        }

        $user->tokens()->delete();

        return $user;
    }
}
