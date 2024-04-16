<?php

namespace App\Repositories\Movies;

use App\Models\Movie;

class MovieRepository implements MovieRepositoryInterface
{
    function __construct(private Movie $entity)
    {
    }

    public function updateOrCreate(array $criteria, array $movie)
    {
        return $this->entity->updateOrCreate($criteria, $movie);
    }

    public function findByUserMovieId(int $movieId, string $userId)
    {
        return $this->entity->where('movie_id', $movieId)->where('user_id', $userId)->first();
    }

    public function unmarkAsFavorite(string $userId, int $movieId)
    {
        $movie = $this->entity->where('user_id', $userId)->where('movie_id', $movieId)->first();
        if (!is_null($movie)) {
            $movie->favorite = false;
            $movie->save();
        }
    }

    public function unmarkAsWatched(string $userId, int $movieId)
    {
        $movie = $this->entity->where('user_id', $userId)->where('movie_id', $movieId)->first();
        if (!is_null($movie)) {
            $movie->watched = false;
            $movie->save();
        }
    }

    public function unmarkAsWatchLater(string $userId, int $movieId)
    {
        $movie = $this->entity->where('user_id', $userId)->where('movie_id', $movieId)->first();
        if (!is_null($movie)) {
            $movie->watch_later = false;
            $movie->save();
        }
    }
}
