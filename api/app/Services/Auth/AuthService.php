<?php

namespace App\Services\Auth;

use App\Services\Auth\DTO\ResponseMeDTO;
use App\Services\Auth\DTO\ResponseWithTokenDTO;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials): ResponseWithTokenDTO
    {
        if (!$token = Auth::attempt($credentials)) {
            throw new UnauthorizedHttpException('token', 'Invalid credentials.');
        }

        return new ResponseWithTokenDTO($token);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function me(): ResponseMeDTO
    {
        $user =  Auth::user();
        return new ResponseMeDTO($user);
    }

    public function refresh(): ResponseWithTokenDTO
    {
        return new ResponseWithTokenDTO(Auth::refresh());
    }
}
