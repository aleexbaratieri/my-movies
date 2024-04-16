<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    function __construct(private readonly AuthServiceInterface $authService)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->only(['email', 'password']));
        return response()->json($token);
    }

    public function me(): JsonResponse
    {
        $user = $this->authService->me();
        return response()->json($user);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        $token = $this->authService->refresh();
        return response()->json($token);
    }
}
