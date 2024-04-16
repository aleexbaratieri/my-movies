<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Services\Users\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    function __construct(private readonly UserServiceInterface $userService)
    {
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = $this->userService->register($request->validated());
        return response()->json(['data' => $user], Response::HTTP_CREATED);
    }
}
