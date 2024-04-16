<?php

namespace App\Services\Auth;

use App\Services\Auth\DTO\ResponseMeDTO;
use App\Services\Auth\DTO\ResponseWithTokenDTO;

interface AuthServiceInterface
{
    public function login(array $credentials): ResponseWithTokenDTO;

    public function logout(): void;

    public function me(): ResponseMeDTO;

    public function refresh(): ResponseWithTokenDTO;
}
