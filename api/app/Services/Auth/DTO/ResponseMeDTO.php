<?php

namespace App\Services\Auth\DTO;

use App\Models\User;
use App\Services\Movies\DTO\MovieDTO;
use Illuminate\Support\Collection;

class ResponseMeDTO
{
    public string $id;
    public string $name;
    public string $surname;
    public string $email;

    /**
     * @param Collection|MovieDTO[] $movies
     */
    public Collection $movies;

    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->email = $user->email;
        $this->movies = $user->movies
            ->map(function ($movie) {
                return new MovieDTO($movie);
            });
    }
}
