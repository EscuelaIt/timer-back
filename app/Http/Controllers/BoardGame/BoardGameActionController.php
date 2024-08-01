<?php

namespace App\Http\Controllers\BoardGame;

use App\Models\BoardGame;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Lib\Crud\ActionHandler;
use App\Actions\Crud\DeleteAction;
use App\Http\Controllers\Controller;

class BoardGameActionController extends Controller
{
    use ApiFeedbackSender, ActionHandler;

    protected $actionTypes = [
        'DeleteAction' => DeleteAction::class,
        // 'ChangeVisibilityAction' => ChangeVisibilityAction::class,
    ];

    protected function getActionModel() {
        return BoardGame::class;
    }
    
}
