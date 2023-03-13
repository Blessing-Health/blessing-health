<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    public function test_login_using_mobile_and_password()
    {
        $this->createUsers();
        $response = $this->postJson(route('login'), [
            'mobile' => '8486935380',
            'password' => 'secret'
        ]);

        $response->assertOk();
        $this->assertArrayHasKey('token', $response->json());
    }

    public function test_login_using_email_and_password()
    {
        $this->createUsers();
        $response = $this->postJson(route('login'), [
            'email' => 'admin@example.com',
            'password' => 'secret'
        ]);

        $response->assertOk();
        $this->assertArrayHasKey('token', $response->json());
    }

    public function test_if_mobile_or_password_is_inavalid()
    {
        $response = $this->postJson(route('login'), [
            'mobile' => '8486935380',
            'password' => 'random'
        ])
            ->assertUnauthorized();
    }

    public function test_if_email_or_password_is_inavalid()
    {
        $response = $this->postJson(route('login'), [
            'email' => 'admin@example.com',
            'password' => 'random'
        ])
            ->assertUnauthorized();
    }

    public function test_if_user_can_logged_out()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->postJson(route('logout'))
            ->assertSuccessful()
            ->assertGuest();
    }
}
