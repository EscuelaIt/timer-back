<?php

namespace App\Http\Controllers\BoardGame;

use App\Models\BoardGame;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BoardGameChangeEssentialController extends Controller
{
    use ApiFeedbackSender;

    public function changeEssential(Request $request, string $id)
    {
        $boardGame = BoardGame::find($id);
        if(! $boardGame) {
            return $this->sendError('No existe este juego de mesa', 404);
        }
        
        $validateRequest = Validator::make($request->all(), [
            'value' => 'boolean',
        ]);

        if($validateRequest->fails()){
            return $this->sendValidationError(
                'Ha ocurrido un error de validación',
                $validateRequest->errors()
            );
        }

        $boardGame->essential = $request->value ?? false;
        $boardGame->save();

        return $this->sendSuccess('juego de mesa actualizado', $boardGame);
    }
}