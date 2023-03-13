<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_register_a_user_using_mobile_otp()
    {
        $this->postJson(route('register'), ['mobile' => '8486935380'])
            ->assertOk();

    }
}
