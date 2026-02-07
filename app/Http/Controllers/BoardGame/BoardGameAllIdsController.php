<?php

namespace App\Http\Controllers\BoardGame;

use App\Http\Controllers\Controller;
use App\Services\BoardGameListService;
use EscuelaIT\APIKit\ResourceListable;

class BoardGameAllIdsController extends Controller
{
    use ResourceListable;

    public function __invoke(BoardGameListService $service)
    {
        return $this->allIds($service);
    }
}
