<?php

namespace App\Services\Users;

use App\Models\User;
use App\Repositories\Users\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function register(array $data): User
    {
        return $this->userRepository->create($data);
    }
}
