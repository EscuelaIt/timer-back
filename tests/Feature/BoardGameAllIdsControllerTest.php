<?php

namespace Tests\Feature;

use App\Models\BoardGame;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BoardGameAllIdsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function get_all_ids_returns_ids(): void
    {
        BoardGame::factory()->count(2)->create();
        $response = $this->get('/api/board-games/allids');

        $response->assertStatus(200);
        $response->assertJsonStructure(['data']);
        $this->assertCount(2, $response->json('data'));
    }
}
