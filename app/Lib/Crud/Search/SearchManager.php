<?php
namespace App\Lib\Crud\Search;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class SearchManager {

    private $request;
    protected $searchValidationRules = [
        'keyword' => 'nullable|string',
        'filters' => 'nullable|array',
        'sortField' => 'nullable|string',
        'sortDirection' => 'nullable|string',
        'per_page' => 'nullable|integer|min:0|max:100',
    ];
    protected $searchData = [];
    protected $searchValidationResults;
    protected $query;

    public function __construct($request) {
        $this->request = $request;
    }

    public function isSearchValid() {
        $this->searchValidationResults = Validator::make($this->request->all(), $this->searchValidationRules);
        return ! $this->searchValidationResults->fails();
    }

    public function getSearchValidationErrors() {
       return $this->searchValidationResults->errors();
    }

    public function search() {
        $this->applySearch();
        return $this->getSearchResults();
    }

    public function getAllSlugs() {
        $this->applySearch();
        return $this->query->get()->pluck('slug');
    }

    private function applySearch() {
        $this->getSearchData();
        $this->query = $this->createQuery();
        $this->applySearchFilters();
        $this->applyRelationship();
    }

    private function getSearchData() {
        $this->searchData['perPage'] = $this->request->query('per_page', 10);
        $this->searchData['sortField'] = $this->request->query('sortField', 'created_at');
        $this->searchData['sortDirection'] = $this->request->query('sortDirection', 'desc');
        $this->searchData['keyword'] = $this->request->query('keyword');
        $this->searchData['filters'] = $this->request->query('filters', []);
        $this->searchData['belongsTo'] = $this->request->query('belongsTo', '');
        $this->searchData['relationId'] = $this->request->query('relationId', '');
        if ($this->searchData['sortField'] == "created") {
          $this->searchData['sortField'] = "created_at";
        }
    }

    abstract protected function createQuery();
    
    protected function applySearchFilters() {
        foreach($this->searchData['filters'] as $filter) {
            $filter = json_decode($filter);
            if($filter->active) {
                $this->query->where($filter->name, $filter->value);
            }
        }
    } 

    private function applyRelationship() {
        if($this->searchData['belongsTo'] != '' && $this->searchData['relationId'] != '') {
            $this->applyCustomRelationship();
        }
    }

    protected function applyCustomRelationship() {
        // De manera predeterminada no hay relaciones que aplicar.
    }

    public function getSearchResults() {
        $countItems = $this->query->count();
        $this->query->orderBy($this->searchData['sortField'], $this->searchData['sortDirection']);

        $paginatedResults = $this->query->simplePaginate($this->searchData['perPage'])->withQueryString();
        
        return [
          'countItems' => $countItems,
          'result' => $paginatedResults,
        ];
    }
}