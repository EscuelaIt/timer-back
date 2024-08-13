<?php
namespace App\Lib\Crud\Search;

use App\Models\BoardGame;
use Illuminate\Support\Facades\Auth;
use App\Lib\Game\UserFavoritesSearcher;

class BoardGameSearchManager extends SearchManager {

    protected function createQuery() {
        return BoardGame::select('id', 'slug', 'name', 'year')->with(['country'])->similar($this->searchData['keyword']);
    }

    protected function applySearchFilters() {
        foreach($this->searchData['filters'] as $filter) {
            //info($filter);
            if($filter["active"] && $filter["active"] != 'false') {
                if($filter["name"] == 'essential') {
                    //info('estoy en filter essential' . $filter["value"]);
                    $this->query->isEssential();
                }
                if($filter["name"] == 'complexity') {
                    //info('estoy en filter complexity' . $filter["value"]);
                    $this->query->complexity($filter["value"]);
                }
                if($filter["name"] == 'profile') {
                    //info('estoy en filter profile' . $filter["value"]);
                    switch($filter["value"]) {
                        case 'hidden_profile':
                            $this->query->hiddenProfile();
                            break;
                        case 'null_profile':
                            $this->query->nullProfile();
                    }
                }
            }
        }
    }

    protected function applyCustomRelationship() {
        $belongsTo = $this->searchData['belongsTo'];
        $relationId = $this->searchData['relationId'];
        info('aplicando relacion ' . $belongsTo . ' con ' . $relationId);
        if($belongsTo == 'country') {
            $this->query->fromCountry($relationId);
        }
    }
}