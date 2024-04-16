<?php

namespace App\Services\Movies;

use App\Services\TheMovieDB\DTO\TheMovieDBDTO;

interface MovieServiceInterface
{
    public function markAsFavorite(TheMovieDBDTO $movie): void;

    public function markAsWatched(TheMovieDBDTO $movie): void;

    public function markAsWatchLater(TheMovieDBDTO $movie): void;

    public function unmarkAsFavorite(int $movieId): void;

    public function unmarkAsWatched(int $movieId): void;

    public function unmarkAsWatchLater(int $movieId): void;
}
