<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /*
     * Тестирует регистрацию с валидными данными
     */
    public function testUserRegistrationWithValidData(): void
    {
        $this->seed(RoleSeeder::class);

        $validatedData = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->email(),
            'password' => '!Password123!',
            'password_repeat' => '!Password123!',
        ];

        $response = $this->postJson(route('auth.register'), $validatedData);
        $response->assertCreated()
            ->assertJsonStructure([
                'message',
                'user' => []
            ]);

        $this->assertDatabaseHas('users', ['email' => $validatedData['email']]);
    }

    /*
     * Тестирует логику регистрации, если данные невалидны
     */
    public function testUserRegistrationWithNotValidData(): void
    {
        $userData = [
            'first_name' => 'Ilya',
            'last_name' => 'Avkhimenko',
            'email' => 'test',
            'password' => 'password',
            'password_repeat' => 'password'
        ];

        $response = $this->postJson(route('auth.register'), $userData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /*
     * Тестирует вход в систему пользователя с валидными данными
     */
    public function testUserLoginWithValidCredentials(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();

        $credentials = [
            'email' => $user->email,
            'password' => 'Password123'
        ];

        $response = $this->postJson(route('auth.login'), $credentials);
        $response->assertOk()->assertJsonStructure(['message', 'token']);

        $token = $response->json('token');
        $this->assertNotNull($token);
    }

    /*
     * Тестирует авторизацию, если данные неверны
     */
    public function testUserLoginWithInvalidCredentials(): void
    {
        $invalidCredentials = [
            'email' => 'test',
        ];

        $response = $this->postJson(route('auth.login'), $invalidCredentials);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);

    }
}
