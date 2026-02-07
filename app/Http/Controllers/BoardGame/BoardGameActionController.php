<?php

namespace App\Http\Controllers\BoardGame;

use EscuelaIT\APIKit\ActionHandler;
use App\Http\Controllers\Controller;
use App\Services\BoardGameActionService;

class BoardGameActionController extends Controller
{
    use ActionHandler;

    public function __invoke(BoardGameActionService $service)
    {
        return $this->handleAction($service);
    }

}
