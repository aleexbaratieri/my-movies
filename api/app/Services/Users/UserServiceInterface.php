<?php

namespace App\Services\Users;

use App\Models\User;

interface UserServiceInterface
{
    public function register(array $data): User;
}
