<?php

namespace App\Repositories\Users;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    function __construct(private readonly User $entity)
    {
    }

    public function findAll(): User
    {
        return $this->entity->get();
    }

    public function getById(string $id): User
    {
        return $this->entity->find($id);
    }

    public function create(array $data): User
    {
        return $this->entity->create($data);
    }

    public function update(string $id, array $data): User
    {
        return $this->entity->where('id', $id)->update($data);
    }

    public function delete(string $id): void
    {
        $this->entity->where('id', $id)->delete();
    }
}
