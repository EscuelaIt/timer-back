<?php

namespace App\Http\Controllers\BoardGame;

use App\Http\Controllers\Controller;
use App\Services\BoardGameListService;
use EscuelaIT\APIKit\ResourceListable;

class BoardGameListController extends Controller
{
    use ResourceListable;

    public function search(BoardGameListService $service) {
        return $this->list($service);
    }
}
