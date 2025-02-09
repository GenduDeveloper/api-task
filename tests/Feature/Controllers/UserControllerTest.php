<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /*
     * Тестирует, что возвращаются пользователи с пагинацией
     */
    public function testActionIndexReturnsPaginatedUsers(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*'],
        );

        User::factory()->count(15)->create();

        $response = $this->getJson(route('users.index'));
        $response->assertOk()
            ->assertJsonStructure([
                'users' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name'
                    ]
                ],
                'current_page',
                'last_page'
            ]);
    }

    /*
     * Тестирует, что метод index возвращает 404, если пользователей не существует
     */
    public function testActionIndexThrowsUserNotFoundException(): void
    {
        $this->withoutMiddleware();

        $response = $this->getJson(route('users.index'));
        $response->assertStatus(404)
            ->assertJsonStructure(['error']);
    }

    /*
     * Тестирует, что выводится определенный пользователь
     */
    public function testActionShowReturnUser(): void
    {
        $this->seed(UserSeeder::class);

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $user = User::factory()->create();

        $response = $this->getJson(route('users.show', $user->id));
        $response->assertOk()
            ->assertJsonStructure(['user'])
            ->assertJsonFragment([
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name
            ]);
    }

    /*
     * Тестирует, что метод show возвращает 404, если пользователя не существует
     */
    public function testActionShowThrowsUserNotFoundException(): void
    {
        $this->withoutMiddleware();
        $nonExistentId = 5000; // костыль, который нужно поменять

        $response = $this->getJson(route('users.show', $nonExistentId));
        $response->assertStatus(404);
        $response->assertJsonStructure(['error']);
    }

    /*
     * Тестирует, что пользователи успешно обновляются
     */
    public function testActionUpdateReturnsAnUpdatedUser(): void
    {
        $this->withoutMiddleware();

        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();

        $userData = [
            'email' => $this->faker->unique()->email()
        ];

        $response = $this->patchJson(route('users.update', $user->id), $userData);
        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'user' => [],
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $userData['email'],
        ]);
    }

    // написать тест на проверку валидации в методе update

    /*
     * Тестирует, что метод destroy успешно удаляет пользователя
     */
    public function testActionDestroySuccessfullyDeletesUser(): void
    {
        $this->withoutMiddleware();

        $user = User::factory()->create();

        $response = $this->deleteJson(route('users.destroy', $user->id));
        $response->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
