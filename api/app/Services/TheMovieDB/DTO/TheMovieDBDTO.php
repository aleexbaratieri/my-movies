<?php

namespace App\Services\TheMovieDB\DTO;

class TheMovieDBDTO
{
    public int $id;
    public string $original_title;
    public string $title;
    public string $poster_path;

    public function __construct(array $movie)
    {
        $this->id = $movie['id'];
        $this->original_title = $movie['original_title'];
        $this->title = $movie['title'];
        $this->poster_path = $movie['poster_path'];
    }
}
