<?php

namespace App\Http\Controllers\BoardGame;

use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use App\Lib\Crud\Search\ResourceSearcher;
use App\Lib\Crud\Search\BoardGameSearchManager;

class BoardGameListController extends Controller
{
    use ApiFeedbackSender, ResourceSearcher;

    protected $searchManagerClass = BoardGameSearchManager::class;
}
