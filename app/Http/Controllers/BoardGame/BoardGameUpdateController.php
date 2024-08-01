<?php

namespace App\Http\Controllers\BoardGame;

use App\Models\BoardGame;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BoardGameUpdateController extends Controller
{
    use ApiFeedbackSender, ControlBoardGameTrait;

    public function update(Request $request, string $id)
    {
        $boardGame = BoardGame::find($id);
        if(! $boardGame) {
            return $this->sendError('No existe este juego de mesa', 404);
        }

        $validateCountry = Validator::make($request->all(), $this->boardGameValidationRules);
        if($validateCountry->fails()){
            return $this->sendValidationError(
                'Ha ocurrido un error de validación',
                $validateCountry->errors()
            );
        }

        $boardGame->name = $request->name;
        $boardGame->slug = $request->slug;
        $boardGame->year = $request->year;
        $boardGame->country_id = $request->country_id;
        $boardGame->save();

        return $this->sendSuccess('juego de mesa actualizado', $boardGame);
    }
}
