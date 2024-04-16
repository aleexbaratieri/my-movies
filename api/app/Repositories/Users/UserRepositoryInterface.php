<?php

namespace App\Repositories\Users;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findAll(): User;

    public function getById(string $id): User;

    public function create(array $data): User;

    public function update(string $id, array $data): User;

    public function delete(string $id): void;
}
