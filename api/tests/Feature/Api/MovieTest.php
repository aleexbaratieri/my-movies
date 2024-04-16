<?php

namespace Tests\Feature\Api;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use WithFaker;

    protected static $token;
    protected static $movie;

    public function setUp(): void
    {
        parent::setUp();

        $password = 'ASDFqwerty123!@#';

        $user = User::factory()->create([
            'password' => $password,
        ]);

        self::$movie = Movie::factory()->create([
            'user_id' => $user->id,
            'movie_id' => 24428,
            'original_title' => 'The Avengers',
            'title' => 'Os Vingadores: The Avengers',
            'poster_path' => '/PtSapjHdDjlVcsqdEo0u7rDE6i.jpg'
        ]);

        $payload = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->postJson('/auth/login', $payload);

        self::$token = $response->json();
    }

    public function test_mark_movie_as_favorite(): void
    {
        $payload = [
            "id" => self::$movie->movie_id,
            "original_title" => self::$movie->original_title,
            "title" => self::$movie->title,
            "poster_path" => self::$movie->poster_path
        ];

        $response = $this->postJson('/movies/favorite', $payload, [
            'Authorization' => "Bearer " . self::$token['access_token'],
        ]);

        $response->assertStatus(200);
        $this->assertEquals($response->json('message'), 'Successfully marked as favorite');
    }

    public function test_mark_movie_as_watched(): void
    {
        $payload = [
            "id" => self::$movie->movie_id,
            "original_title" => self::$movie->original_title,
            "title" => self::$movie->title,
            "poster_path" => self::$movie->poster_path
        ];

        $response = $this->postJson('/movies/watched', $payload, [
            'Authorization' => "Bearer " . self::$token['access_token'],
        ]);

        $response->assertStatus(200);
        $this->assertEquals($response->json('message'), 'Successfully marked as watched');
    }

    public function test_mark_movie_as_watch_later(): void
    {
        $payload = [
            "id" => self::$movie->movie_id,
            "original_title" => self::$movie->original_title,
            "title" => self::$movie->title,
            "poster_path" => self::$movie->poster_path
        ];

        $response = $this->postJson('/movies/watch-later', $payload, [
            'Authorization' => "Bearer " . self::$token['access_token'],
        ]);

        $response->assertStatus(200);
        $this->assertEquals($response->json('message'), 'Successfully marked as watch later');
    }

    public function test_unmark_movie_as_favorite(): void
    {
        $response = $this->deleteJson('movies/' . self::$movie->movie_id . '/favorite', [], [
            'Authorization' => "Bearer " . self::$token['access_token'],
        ]);

        $response->assertStatus(200);
        $this->assertEquals($response->json('message'), 'Successfully unmarked as favorite');
    }

    public function test_unmark_movie_as_watched(): void
    {
        $response = $this->deleteJson('movies/' . self::$movie->movie_id . '/watched', [], [
            'Authorization' => "Bearer " . self::$token['access_token'],
        ]);

        $response->assertStatus(200);
        $this->assertEquals($response->json('message'), 'Successfully unmarked as watched');
    }

    public function test_unmark_movie_as_watch_later(): void
    {
        $response = $this->deleteJson('movies/' . self::$movie->movie_id . '/watch-later', [], [
            'Authorization' => "Bearer " . self::$token['access_token'],
        ]);

        $response->assertStatus(200);
        $this->assertEquals($response->json('message'), 'Successfully unmarked as watch later');
    }
}
