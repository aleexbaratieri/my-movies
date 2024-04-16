<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkMovieRequest;
use App\Services\Movies\MovieServiceInterface;
use App\Services\TheMovieDB\DTO\TheMovieDBDTO;
use App\Services\TheMovieDB\TheMovieDBServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    function __construct(
        private readonly TheMovieDBServiceInterface $tmdbService,
        private readonly MovieServiceInterface $movieService,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $page = 1;
        if ($request->page) {
            $page = $request->page;
        }

        if ($request->filter) {
            $movies = $this->tmdbService->searchMovies($request->filter, $page);
            return response()->json(['data' => $movies]);
        }

        $movies = $this->tmdbService->getMovies($page);
        return response()->json(['data' => $movies]);
    }

    public function show(int $movieId): JsonResponse
    {
        $movie = $this->tmdbService->getMovieById($movieId);
        return response()->json(['data' => $movie]);
    }

    public function markAsfavorite(MarkMovieRequest $request): JsonResponse
    {
        $data = new TheMovieDBDTO($request->validated());

        $this->movieService->markAsFavorite($data);

        return response()->json(['message' => 'Successfully marked as favorite']);
    }

    public function markAsWatched(MarkMovieRequest $request): JsonResponse
    {
        $data = new TheMovieDBDTO($request->validated());

        $this->movieService->markAsWatched($data);

        return response()->json(['message' => 'Successfully marked as watched']);
    }

    public function markAsWatchLater(MarkMovieRequest $request): JsonResponse
    {
        $data = new TheMovieDBDTO($request->validated());

        $this->movieService->markAsWatchLater($data);

        return response()->json(['message' => 'Successfully marked as watch later']);
    }

    public function unmarkAsfavorite(int $movieId): JsonResponse
    {
        $this->movieService->unmarkAsFavorite($movieId);

        return response()->json(['message' => 'Successfully unmarked as favorite']);
    }

    public function unmarkAsWatched(int $movieId): JsonResponse
    {
        $this->movieService->unmarkAsWatched($movieId);

        return response()->json(['message' => 'Successfully unmarked as watched']);
    }

    public function unmarkAsWatchLater(int $movieId): JsonResponse
    {
        $this->movieService->unmarkAsWatchLater($movieId);

        return response()->json(['message' => 'Successfully unmarked as watch later']);
    }
}
