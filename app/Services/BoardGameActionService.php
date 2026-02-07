<?php

namespace App\Services;

use App\Models\BoardGame;
use App\Actions\Crud\DeleteAction;
use EscuelaIT\APIKit\ActionService;
use App\Actions\Crud\DemoChangeEssentialAction;
use App\Actions\DemoChangeNameAction;

class BoardGameActionService extends ActionService {
    protected string $actionModel = BoardGame::class;
    protected array $actionTypes = [
        'DeleteAction' => DeleteAction::class,
        'DemoChangeEssentialAction' => DemoChangeEssentialAction::class,
        'DemoChangeNameAction' => DemoChangeNameAction::class,
    ];
}
