<?php

namespace App\Http\Controllers\BoardGame;

use App\Models\BoardGame;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;

class BoardGameDestroyController extends Controller
{
    use ApiFeedbackSender;
    
     public function destroy(string $id)
    {
        $boardGame = BoardGame::find($id);
        if(! $boardGame) {
            return $this->sendError('No existe este juego de mesa', 404);
        }

        $boardGame->delete();

        return $this->sendSuccess('Juego de mesa borrado', null);
    }
}
