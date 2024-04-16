<?php

namespace App\Services\TheMovieDB;

interface TheMovieDBServiceInterface
{
    public function getMovies(int $page = 1);

    public function searchMovies(string $query, int $page = 1);

    public function getMovieById(int $movieId);
}
