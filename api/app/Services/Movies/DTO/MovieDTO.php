<?php

namespace App\Services\Movies\DTO;

use App\Models\Movie;

class MovieDTO
{
    public ?string $id;
    public ?string $user_id;
    public int $movie_id;
    public string $original_title;
    public string $title;
    public string $poster_path;
    public bool $favorite;
    public bool $watched;
    public bool $watch_later;

    public function __construct(Movie $movie)
    {
        $this->id = $movie->id;
        $this->user_id = $movie->user_id;
        $this->movie_id = $movie->movie_id;
        $this->original_title = $movie->original_title;
        $this->title = $movie->title;
        $this->poster_path = $movie->poster_path;
        $this->favorite = $movie->favorite ?? false;
        $this->watched = $movie->watched ?? false;
        $this->watch_later = $movie->watch_later ?? false;
    }
}
