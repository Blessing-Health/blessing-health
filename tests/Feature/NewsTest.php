<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    protected $news;
    public function setUp(): void
    {
        parent::setUp();
        $user = $this->authUser();
        $this->news = $this->createNews([
            'content' => 'my list',
            'created_by' => $user->id
        ]);
    }
    public function test_fetch_all_news()
    {
        $response = $this->getJson(route('news.index'))
            ->assertOk();

            $this->assertCount(1, $response->json());
            $this->assertEquals("my list", $response[0]['content']);
    }

    public function test_fetch_single_news()
    {
        $response = $this->getJson(route('news.show', $this->news->id))
            ->assertOk()
            ->json();
        $this->assertEquals($this->news->content, $response['content']);
    }

    public function test_store_news()
    {
        $news = News::factory()->make();
        $response = $this->postJson(route('news.store'), [
            'content' => 'this is test content'
        ])
            ->assertCreated()
            ->json();
        $this->assertEquals('this is test content', $response['content']);
        $this->assertDatabaseHas('news', ['content' => 'this is test content']);
    }

    public function test_while_storing_news_content_is_required()
    {
        $this->withExceptionHandling();
        $this->postJson(route('news.store'))
            ->assertUnprocessable();
    }

    public function test_delete_news()
    {
        $this->deleteJson(route('news.destroy', $this->news->id))
            ->assertNoContent();
        $this->assertDatabaseMissing('news', [ 'content' => $this->news->content]);
    }

    public function test_update_news()
    {
        $this->putJson(route('news.update', $this->news->id), ['content' => 'the list is updated'])
            ->assertOk();
        $this->assertDatabaseHas('news', ['id' => $this->news->id, 'content' => 'the list is updated']);
    }

    public function test_while_updating_news_content_is_required()
    {
        $this->withExceptionHandling();
        $this->putJson(route('news.update', $this->news->id))
            ->assertUnprocessable();
    }
}
