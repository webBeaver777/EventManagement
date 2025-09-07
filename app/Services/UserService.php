<?php

namespace App\Services;

use App\Exceptions\User\UserAuthFailedException;
use App\Exceptions\User\UserNotFoundException;
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

    /**
     * @throws UserNotFoundException
     */
    public function getAuthenticatedUser(): User
    {
        $user = auth()->user();
        if (! $user) {
            throw new UserNotFoundException;
        }

        return $user;
    }

    /**
     * @throws UserAuthFailedException
     */
    public function login(array $data): User
    {
        $login = $data['login'] ?? null;
        $password = $data['password'] ?? null;

        if (! $login || ! $password) {
            throw new UserAuthFailedException;
        }

        $user = User::where('login', $login)->first();
        if (! $user || ! Hash::check($password, $user->password)) {
            throw new UserAuthFailedException;
        }

        $user->tokens()->delete();

        return $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function getUserByIdOrFail(int $id): User
    {
        $user = User::find($id);
        if (! $user) {
            throw new UserNotFoundException;
        }

        return $user;
    }

    public function formatUser(User $user): array
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'login' => $user->login,
            'birth_date' => $user->birth_date,
            'registered_at' => $user->registered_at,
        ];
    }

    public function formatUserWithToken(User $user, string $token): array
    {
        return [
            'user' => $this->formatUser($user),
            'token' => $token,
        ];
    }

    /**
     * @throws UserNotFoundException
     */
    public function getFormattedAuthenticatedUser(): array
    {
        $user = $this->getAuthenticatedUser();

        return $this->formatUser($user);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getFormattedUserById(int $id): array
    {
        $user = $this->getUserByIdOrFail($id);

        return $this->formatUser($user);
    }
}
