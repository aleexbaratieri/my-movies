<?php

namespace App\Services\TheMovieDB;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TheMovieDBService implements TheMovieDBServiceInterface
{
    private string $token;

    private string $basePath;

    private array $defaultParams;

    function __construct()
    {
        $this->token = config('the-movie-db.token');
        $this->basePath = config('the-movie-db.base-path');
        $this->defaultParams = config('the-movie-db.default-params');
    }

    public function getMovies(int $page = 1)
    {
        $this->defaultParams['page'] = $page;
        $response = Http::withToken($this->token)->get($this->basePath . 'discover/movie', $this->defaultParams);

        if ($response->ok()) {
            return $response->json();
        }

        throw new BadRequestHttpException('Bad Request');
    }

    public function searchMovies(string $query, int $page = 1)
    {
        $this->defaultParams['query'] = $query;
        $this->defaultParams['page'] = $page;
        $response = Http::withToken($this->token)->get($this->basePath . 'search/movie', $this->defaultParams);

        if ($response->ok()) {
            return $response->json();
        }

        throw new BadRequestHttpException('Bad Request');
    }

    public function getMovieById(int $movieId)
    {
        $this->defaultParams['append_to_response'] = 'credits';
        $response = Http::withToken($this->token)->get($this->basePath . 'movie/' . $movieId, $this->defaultParams);

        if ($response->ok()) {
            return $response->json();
        }

        throw new BadRequestHttpException('Bad Request');
    }
}
