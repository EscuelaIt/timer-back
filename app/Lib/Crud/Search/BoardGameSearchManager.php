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
                if($filter["name"] == 'bgg_id') {
                    //info('estoy en filter name = public_id: ' . $filter["value"]);
                    $this->query->where('bgg_id', $filter["value"]);
                }
                if($filter["name"] == 'favorited') {
                    //info('estoy en filter favorited' . $filter["value"]);
                    $this->query->favorited();
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
        if($belongsTo == 'publisher') {
            $this->query->fromPublisherSlug($relationId);
        }
        if($belongsTo == 'category') {
            $this->query->fromCategorySlug($relationId);
        }
    }
}