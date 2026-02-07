<?php

namespace App\Services;

use App\Models\BoardGame;
use EscuelaIT\APIKit\ListService;

class BoardGameListService extends ListService {
    protected string $listModel = BoardGame::class;
    protected array $searchConfiguration = [
        'perPage' => 10,
        'sortField' => null,
        'sortDirection' => 'asc',
        'keyword' => null,
        'filters' => [],
        'include' => ['country'],
        'belongsTo' => null,
        'relationId' => null,
    ];
    protected function applyKeywordFilter(?string $keyword): void
    {
        $this->query->similar($keyword);
    }
}
