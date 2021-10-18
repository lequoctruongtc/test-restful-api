<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_success()
    {
        User::factory()->create([
            'email' => 'example@gmail.com',
            'password' => Hash::make('password')
        ]);
        $response = $this->postJson('/api/v1/auth/login',
            [
                'email' => 'example@gmail.com',
                'password' => 'password'
            ]
        );

        $response->assertOk()->assertJsonStructure([
            "access_token",
            "token_type",
            "expires_in",
        ]);
    }

    public function test_login_fail_with_incorrect_password()
    {
        User::factory()->create([
            'email' => 'example@gmail.com',
            'password' => Hash::make('password1')
        ]);
        $response = $this->postJson('/api/v1/auth/login',
            [
                'email' => 'example@gmail.com',
                'password' => 'password'
            ]
        );

        $response->assertStatus(401)->assertJson(["error" => "Unauthorized"]);
    }

    public function test_login_validation()
    {
        User::factory()->create([
            'email' => 'example@gmail.com',
            'password' => Hash::make('password')
        ]);
        $response = $this->postJson('/api/v1/auth/login',
            [
                'email' => '',
                'password' => ''
            ]
        );

        $response->assertStatus(422)->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "email" => ["The email field is required."],
                "password" => ["The password field is required."]
            ]
        ]);
    }
}
