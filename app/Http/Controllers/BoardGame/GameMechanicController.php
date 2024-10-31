<?php

namespace App\Http\Controllers\BoardGame;

use App\Models\Mechanic;
use App\Models\BoardGame;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use App\Lib\Mechanic\MechanicsAssociator;


class GameMechanicController extends Controller
{
    use ApiFeedbackSender;

    public function getGameMechanics($id) {
        $game = BoardGame::where('id', $id)->with(['mechanics'])->first();
        if(! $game) {
            return $this->sendError('No se encuentra este juego', 404);
        }
        $mechanicsAssociator = new MechanicsAssociator($game);
        $mechanicsSummary = $mechanicsAssociator->getMechanics();
        return $this->sendSuccess('Game mechanics', $mechanicsSummary);
    }

    public function checkGameMechanics(Request $request, $id) {
        $game = BoardGame::find($id);
        if(! $game) {
            return $this->sendError('No se encuentra este juego', 404);
        }
        $mechanicsAssociator = new MechanicsAssociator($game);
        $mechanicsAssociator->saveMechanic($request->id, $request->checked);
        return $this->sendSuccess('Action success', null);
    }
}
