<?php

namespace App\Http\Controllers\BoardGame;

use App\Models\BoardGame;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BoardGames\ControlBoardGameTrait;

class BoardGameStoreController extends Controller
{
    use ApiFeedbackSender, ControlBoardGameTrait;

    public function store(Request $request)
     {
         $user = Auth::user();
 
         if($user->cannot('create', BoardGame::class)) {
            return $this->sendError('No estás autorizado para realizar esta acción', 403);
         }
 
         $validateBoardGame = Validator::make($request->all(), $this->boardGameValidationRules);
         if($validateBoardGame->fails()){
             return $this->sendValidationError(
                 'Ha ocurrido un error de validación',
                 $validateBoardGame->errors()
             );
         }
         
         $boardGame = BoardGame::create([
             'slug' => $request->slug,
             'name' => $request->name,
             'year' => $request->year,
             'country_id' => $request->country_id,
         ]);
 
         return $this->sendSuccess(
             'El juego de mesa se ha creado',
             $boardGame
         );
     }
}
