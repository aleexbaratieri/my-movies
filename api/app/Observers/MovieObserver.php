<?php

namespace App\Observers;

use App\Models\Movie;

class MovieObserver
{
    /**
     * Handle the Movie "updated" event.
     */
    public function updated(Movie $movie): void
    {
        if (!$movie->favorite && !$movie->watched && !$movie->watch_later) {
            $movie->delete();
        }
    }
}
