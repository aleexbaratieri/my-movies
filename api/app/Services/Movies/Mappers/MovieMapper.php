<?php

namespace App\Services\Movies\Mappers;

use App\Models\Movie;
use App\Services\Movies\DTO\MovieDTO;
use App\Services\TheMovieDB\DTO\TheMovieDBDTO;
use Illuminate\Support\Facades\Auth;

class MovieMapper
{
    static function mapTmdbToMovieDto(TheMovieDBDTO $tmdbMovie): MovieDTO
    {
        $movie = new Movie();
        $movie->user_id = Auth::user()->id;
        $movie->movie_id = $tmdbMovie->id;
        $movie->original_title = $tmdbMovie->original_title;
        $movie->title = $tmdbMovie->title;
        $movie->poster_path = $tmdbMovie->poster_path;

        return new MovieDTO($movie);
    }
}
