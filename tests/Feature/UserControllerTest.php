<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

class UserControllerTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Crie um usuário autenticado para os testes
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_retrieves_all_users_with_auth()
    {
        // Crie usuários adicionais
        User::factory()->count(5)->create();

        // Ative a autenticação
        actingAs($this->user, 'sanctum');

        $response = $this->get('/users');

        $response->assertOk()
                 ->assertJsonCount(6); // Incluindo o usuário autenticado
    }

    /** @test */
    public function it_shows_a_single_user_with_auth()
    {
        actingAs($this->user, 'sanctum');

        $response = $this->get("/users/{$this->user->id}");

        $response->assertOk()
                 ->assertJsonFragment(['id' => $this->user->id]);
    }

    /** @test */
    public function it_updates_a_user_with_auth()
    {
        actingAs($this->user, 'sanctum');

        $data = ['name' => 'Updated Name'];

        $response = $this->put("/users/{$this->user->id}", $data);

        $response->assertOk()
                 ->assertJsonFragment(['message' => 'Successfully updated user']);

        $this->assertEquals('Updated Name', $this->user->fresh()->name);
    }

    /** @test */
    public function it_deletes_a_user_with_auth()
    {
        actingAs($this->user, 'sanctum');

        $response = $this->delete("/users/{$this->user->id}");

        $response->assertNoContent();

        $this->assertNull(User::find($this->user->id));
    }
}
