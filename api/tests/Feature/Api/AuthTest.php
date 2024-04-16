<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;

    protected static $user;
    protected static $password = 'ASDFqwerty123!@#';

    public function setUp(): void
    {
        parent::setUp();

        self::$user = User::factory()->create([
            'password' => self::$password,
        ]);
    }

    public function test_auth_login_fail(): void
    {
        $payload = [
            'email' => $this->faker->safeEmail(),
            'password' => 'wrong_password',
        ];

        $response = $this->postJson('/auth/login', $payload);

        $response->assertStatus(401);
    }

    public function test_auth_login_with_invalid_payload(): void
    {
        $payload = [
            'email' => 'notemail',
            'password' => 'wrong_password',
        ];

        $response = $this->postJson('/auth/login', $payload);

        $response->assertStatus(422);
    }

    public function test_auth_login(): void
    {
        $payload = [
            'email' => self::$user->email,
            'password' => self::$password,
        ];

        $response = $this->postJson('/auth/login', $payload);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }

    public function test_auth_me_without_token(): void
    {
        $response = $this->getJson('auth/me');

        $response->assertStatus(401);
    }

    public function test_auth_me(): void
    {
        $payload = [
            'email' => self::$user->email,
            'password' => self::$password,
        ];

        $response = $this->postJson('/auth/login', $payload);
        $token = $response->json('access_token');

        $response = $this->getJson('auth/me', [
            'Authorization' => "Bearer " . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'name',
            'surname',
            'email',
            'movies',
        ]);
    }

    public function test_auth_logout_without_token(): void
    {
        $response = $this->postJson('auth/logout');

        $response->assertStatus(401);
    }

    public function test_auth_logout(): void
    {
        $payload = [
            'email' => self::$user->email,
            'password' => self::$password,
        ];

        $auth = $this->postJson('/auth/login', $payload);
        $token = $auth->json('access_token');

        $response = $this->postJson('auth/logout', [], [
            'Authorization' => "Bearer " . $token,
        ]);

        $response->assertStatus(200);
        $response->assertContent(
            json_encode(['message' => 'Successfully logged out'])
        );

        $validateLogout = $this->getJson('auth/me', [
            'Authorization' => "Bearer " . $token,
        ]);

        $validateLogout->assertStatus(401);
    }

    public function test_auth_refresh_token_without_token(): void
    {
        $response = $this->postJson('auth/refresh');

        $response->assertStatus(401);
    }

    public function test_auth_refresh_token(): void
    {
        $payload = [
            'email' => self::$user->email,
            'password' => self::$password,
        ];

        $auth = $this->postJson('/auth/login', $payload);
        $token = $auth->json('access_token');

        $response = $this->postJson('auth/refresh', [], [
            'Authorization' => "Bearer " . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
        ]);
    }
}
