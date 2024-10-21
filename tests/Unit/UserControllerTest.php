<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

uses(RefreshDatabase::class);

class UserControllerTest extends TestCase
{
    protected $userController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userController = new UserController();
    }

    /** @test */
    public function it_can_retrieve_all_users()
    {
        User::factory()->count(5)->create();

        $response = $this->userController->index();

        $this->assertCount(5, $response);
    }

    /** @test */
    public function it_can_show_a_single_user()
    {
        $user = User::factory()->create();

        $response = $this->userController->show($user);

        $this->assertEquals($user->id, $response->id);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();
        $request = new Request(['name' => 'Updated Name']);

        $response = $this->userController->update($request, $user);

        $this->assertEquals('Successfully updated user', $response->getOriginalContent()['message']);
        $this->assertEquals('Updated Name', $user->fresh()->name);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $this->userController->destroy($user);

        $this->assertNull(User::find($user->id));
    }
}
