<?php

namespace Tests\Feature;

use App\Models\BoardGame;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BoardGameActionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function board_game_action_fails_when_no_data_recived(): void
    {
        $response = $this->postJson('/api/board-games/action');
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Entidad no procesable',
        ]);
        $response->assertJsonValidationErrors(['type']);
    }

    #[Test]
    public function board_game_action_fails_when_action_type_is_not_valid(): void
    {
        $response = $this->postJson('/api/board-games/action', [
            'type' => 'hohoho',
            'relatedIds' => [1],
            'data' => []
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The action type is not valid.',
        ]);
    }

    #[Test]
    public function delete_action_deletes_board_game(): void
    {
        BoardGame::factory()->create();

        $response = $this->postJson('/api/board-games/action', [
            'type' => 'DeleteAction',
            'relatedIds' => [1],
            'data' => []
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Borrado 1 elemento con éxito',
        ]);

        $this->assertDatabaseMissing('board_games', ['id' => 1]);
    }

    #[Test]
    public function is_essential_action_makes_a_board_game_essential() {
         $boardGame = BoardGame::factory()->create([
            'essential' => false,
         ]);
         $response = $this->postJson('/api/board-games/action', [
            'type' => 'DemoChangeEssentialAction',
            'relatedIds' => [$boardGame->id],
            'data' => [
                'essential' => true,
            ]
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Cambiado valor essential',
        ]);

        $this->assertDatabaseHas('board_games', ['id' => $boardGame->id, 'essential' => true]);
    }

     #[Test]
    public function change_action_changes_name() {
         $boardGame = BoardGame::factory()->create();
          $response = $this->postJson('/api/board-games/action', [
            'type' => 'DemoChangeNameAction',
            'relatedIds' => [$boardGame->id],
            'data' => [
                'name' => 'Nuevo nombre',
            ]
        ]);
        $response->assertStatus(200);

        $this->assertDatabaseHas('board_games', ['id' => $boardGame->id, 'name' => 'Nuevo nombre']);
    }
}
