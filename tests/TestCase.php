<?php

namespace Tests;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $news, $users;
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function createNews($args = [])
    {
        return News::factory()->create($args);
    }

    public function createUsers($args= [])
    {
        return User::factory()->create($args);
    }

    public function authUser()
    {
        $user = $this->createUsers();
        Sanctum::actingAs($user);
        return $user;
    }
}
