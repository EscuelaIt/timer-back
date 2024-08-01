<?php

namespace App\Lib\Crud\Search;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ResourceSearcher {

  public function search(Request $request) {
    $searchManager = new $this->searchManagerClass($request);  

    if (! $searchManager->isSearchValid()) {
        $validationErrors = $searchManager->getSearchValidationErrors();
        return $this->sendValidationError($validationErrors);
    }

    $results = $searchManager->search();
    return $this->sendSuccess("Encontrados {$results['countItems']} juegos", $results);
  }

  public function allids(Request $request) {
    $searchManager = new $this->searchManagerClass($request);
    $ids = $searchManager->getAllIds();
    return $this->sendSuccess('All ids', $ids);
  }

}