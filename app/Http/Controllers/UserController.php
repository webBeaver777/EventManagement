<?php

namespace App\Http\Controllers;

use App\Exceptions\User\UserAuthFailedException;
use App\Exceptions\User\UserNotFoundException;
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

        return ApiResponse::success($this->userService->formatUserWithToken($user, $token));
    }

    public function me(): JsonResponse
    {
        try {
            $result = $this->userService->getFormattedAuthenticatedUser();
        } catch (UserNotFoundException $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }

        return ApiResponse::success($result);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $credentials = $request->only('login', 'password');
        try {
            $user = $this->userService->login($credentials);
        } catch (UserAuthFailedException $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }
        $token = $user->createToken('api_token')->plainTextToken;

        return ApiResponse::success($this->userService->formatUserWithToken($user, $token));
    }

    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->userService->getFormattedUserById($id);
        } catch (UserNotFoundException $e) {
            return ApiResponse::error($e->getMessage(), $e->getCode());
        }

        return ApiResponse::success($result);
    }
}
