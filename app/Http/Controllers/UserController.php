<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = $this->userService->register($request->validated());

        $token = $user->createToken('api_token')->plainTextToken;

        return ApiResponse::success([
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'login' => $user->login,
            'birth_date' => $user->birth_date,
        ], ['token' => $token]);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $credentials = $request->only('login', 'password');
        $user = $this->userService->login($credentials);

        if (! $user) {
            return ApiResponse::error('Неверный логин или пароль', 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return ApiResponse::success([
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'login' => $user->login,
        ], ['token' => $token]);
    }
}
