<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UsersCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_can_view_user_listing()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($user)->get('/users');
        $response->assertStatus(200)
            ->assertSee(trans('users.listing'))
            ->assertViewIs('users.list')
            ->assertSeeInOrder([$otherUser->firstname, $otherUser->lastname]);
    }

    public function test_can_view_create_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/users/create');
        $response->assertStatus(200)
            ->assertSee(trans('users.create_user'))
            ->assertViewIs('users.create');
    }

    public function test_can_create_unique_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirectToRoute('users.index');
    }

    public function test_create_user_validation_fails()
    {
        $user = User::factory()->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response = $this->actingAs($user)->post('/users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertInvalid();

        $this->assertDatabaseCount('users', 2);
    }

    public function test_can_view_edit_user()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($user)->get('/users/'.$otherUser->id.'/edit');

        $response->assertStatus(200)
            ->assertSee(trans('users.edit_user'))
            ->assertViewIs('users.edit')
            ->assertSee($otherUser->name);
    }

    public function test_view_edit_user_not_found()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/users/'.rand(10, 100).'/edit');

        $response->assertStatus(404);
    }

    public function test_can_edit_user()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($user)->patch('/users/'.$otherUser->id, [
            'name' => $otherUser->name.'Test',
            'email' => 'Test'.$otherUser->email,
        ]);

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'name' => $otherUser->name.'Test',
            'email' => 'Test'.$otherUser->email,
        ]);

        $response->assertRedirectToRoute('users.index');
    }

    public function test_edit_user_validation_fails()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($user)->patch('/users/'.$otherUser->id, [
            'name' => $otherUser->name.'Test',
            'email' => $user->email,
        ]);

        $response->assertInvalid();

        $this->assertDatabaseCount('users', 2);
    }

    public function test_can_delete_user()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($user)->delete('/users/'.$otherUser->id);

        $this->assertDatabaseMissing('users', [
            'email' => $otherUser->email,
        ]);

        $response->assertRedirectToRoute('users.index');
    }

    public function test_delete_user_not_found()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($user)->delete('/users/'.rand(10, 100));

        $response->assertStatus(404);
    }
}
