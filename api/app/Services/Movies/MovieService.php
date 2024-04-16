<?php

namespace App\Services\Movies;

use App\Repositories\Movies\MovieRepositoryInterface;
use App\Services\Movies\Mappers\MovieMapper;
use App\Services\TheMovieDB\DTO\TheMovieDBDTO;
use Illuminate\Support\Facades\Auth;

class MovieService implements MovieServiceInterface
{
    function __construct(private readonly MovieRepositoryInterface $movieRepo)
    {
    }

    public function markAsFavorite(TheMovieDBDTO $tmdbMovie): void
    {
        $movie = MovieMapper::mapTmdbToMovieDto($tmdbMovie);
        $this->movieRepo->updateOrCreate(
            ['user_id' => $movie->user_id, 'movie_id' => $movie->movie_id],
            ['original_title' => $movie->original_title, 'title' => $movie->title, 'poster_path' => $movie->poster_path, 'favorite' => true],
        );
    }

    public function markAsWatched(TheMovieDBDTO $tmdbMovie): void
    {
        $movie = MovieMapper::mapTmdbToMovieDto($tmdbMovie);
        $this->movieRepo->updateOrCreate(
            ['user_id' => $movie->user_id, 'movie_id' => $movie->movie_id],
            ['original_title' => $movie->original_title, 'title' => $movie->title, 'poster_path' => $movie->poster_path, 'watched' => true, 'watch_later' => false],
        );
    }

    public function markAsWatchLater(TheMovieDBDTO $tmdbMovie): void
    {
        $movie = MovieMapper::mapTmdbToMovieDto($tmdbMovie);
        $this->movieRepo->updateOrCreate(
            ['user_id' => $movie->user_id, 'movie_id' => $movie->movie_id],
            ['original_title' => $movie->original_title, 'title' => $movie->title, 'poster_path' => $movie->poster_path, 'watched' => false, 'watch_later' => true],
        );
    }

    public function unmarkAsFavorite(int $movieId): void
    {
        $this->movieRepo->unmarkAsFavorite(Auth::user()->id, $movieId);
    }

    public function unmarkAsWatched(int $movieId): void
    {
        $this->movieRepo->unmarkAsWatched(Auth::user()->id, $movieId);
    }

    public function unmarkAsWatchLater(int $movieId): void
    {
        $this->movieRepo->unmarkAsWatchLater(Auth::user()->id, $movieId);
    }
}
