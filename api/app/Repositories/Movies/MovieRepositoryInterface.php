<?php

namespace App\Repositories\Movies;

interface MovieRepositoryInterface
{
    public function updateOrCreate(array $criteria, array $movie);

    public function findByUserMovieId(int $movieId, string $userId);

    public function unmarkAsFavorite(string $userId, int $movieId);

    public function unmarkAsWatched(string $userId, int $movieId);

    public function unmarkAsWatchLater(string $userId, int $movieId);
}
