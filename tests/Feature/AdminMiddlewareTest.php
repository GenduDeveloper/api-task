<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /*
     * Тестирует, что админ получает доступ к административному маршруту
     */
    public function testThatAdminHasAccessRoute(): void
    {
        $admin = User::factory()->create(['role_id' => Role::ADMIN_ROLE_ID]);

        Sanctum::actingAs($admin, ['*']);

        $response = $this->getJson(route('roles.index'));
        $response->assertStatus(200);
    }

    /*
     * Тестирует, что обычный пользователь не получает доступа к административным маршрутам
     */
    public function testThatUserIsNotAccessingAdminRoute(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson(route('roles.index'));
        $response->assertStatus(403);
    }
}
