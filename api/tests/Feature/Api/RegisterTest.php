<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    protected static $password = 'ASDFqwerty123!@#';

    public function test_register_new_user_with_invalid_paylaod(): void
    {
        $payload = [
            'email' => $this->faker()->safeEmail(),
            'password' => self::$password,
        ];

        $response = $this->postJson('/register', $payload);

        $response->assertStatus(422);
    }

    public function test_register_new_user_with_valid_paylaod(): void
    {
        $payload = [
            'name' => $this->faker()->firstName(),
            'surname' => $this->faker()->lastName(),
            'email' => $this->faker()->safeEmail(),
            'password' => self::$password,
            'password_confirmation' => self::$password
        ];

        $response = $this->postJson('/register', $payload);

        $response->assertStatus(201);
    }
}
