<?php

namespace Tests\Feature;

use App\Models\BoardGame;
use App\Models\Tag;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BoardGameTagFilterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function filtering_by_tag_returns_only_items_with_that_tag(): void
    {
        // Create two tags
        $tagA = Tag::factory()->create();
        $tagB = Tag::factory()->create();

        // Create two board games and attach tagA to one of them
        $gameWithTag = BoardGame::factory()->create();
        $gameWithoutTag = BoardGame::factory()->create();

        $gameWithTag->tags()->attach($tagA->id);

        // Call the endpoint with a filters param targeting the tag
        $response = $this->get('/api/board-games?filters[0][name]=tag&filters[0][active]=true&filters[0][value]=' . $tagA->id);

        $response->assertStatus(200);

        // The APIResponse::ok wrapper nests the payload under data
        $responseData = $response->json('data');

        // Expect countItems to be 1 and result.data to contain the single game
        $this->assertEquals(1, $responseData['countItems']);
        $this->assertCount(1, $responseData['result']['data']);
        $this->assertEquals($gameWithTag->id, $responseData['result']['data'][0]['id']);
    }
}
