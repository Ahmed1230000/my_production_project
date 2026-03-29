<?php

namespace Tests\Feature\Auth;

use App\Domains\Auth\Repositories\Contracts\AuthTokenServiceInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */

    protected function setUp(): void
    {
        parent::setUp();
        $this->mock(AuthTokenServiceInterface::class, function ($mock) {
            $mock->shouldReceive('generateToken')
                ->andReturn('mocked_token');
        });
    }
    public function test_user_can_register_successfully()
    {
        $request = $this->postJson('/api/register', [
            'name' => $this->faker->name(),
            'email' => 'admin@system.com',
            'password' => 'Ahmed123!@#',
            'password_confirmation' => 'Ahmed123!@#',
        ]);

        $request->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => $request['data']['email'],
        ]);
    }

    public function test_user_can_login_successfully()
    {
        $user = User::factory()->create([
            'name' => $this->faker->name(),
            'email' => 'admin@system.com',
            'password' => bcrypt('Ahmed123!@#'),
        ]);

        $request = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'Ahmed123!@#',
        ]);

        $request->assertStatus(200);
    }

    public function test_user_login_with_wrong_password()
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@system.com',
            'password' => bcrypt('Ahmed123!@#'),
        ]);

        $request = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'WrongPassword',
        ]);

        $request->assertStatus(401);
    }

    public function test_user_can_logout_successfully()
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@system.com',
            'password' => bcrypt('Ahmed123!@#'),
        ]);

        $this->mock(AuthTokenServiceInterface::class, function ($mock) use ($user) {
            $mock->shouldReceive('revokeToken')
                ->once()
                ->with($user->id);
        });

        $request = $this->actingAs($user, 'api')->postJson('api/logout');

        $request->assertStatus(200);
    }
    public function test_logout_requires_authentication()
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }
}
