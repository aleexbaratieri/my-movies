<?php

namespace App\Services\Auth\DTO;

use Illuminate\Support\Facades\Auth;

class ResponseWithTokenDTO
{
    public string $access_token;
    public string $token_type;
    public string $expires_in;

    public function __construct(mixed $token)
    {
        $this->access_token = $token;
        $this->token_type = 'bearer';
        $this->expires_in = Auth::factory()->getTTL() * 60;
    }
}
