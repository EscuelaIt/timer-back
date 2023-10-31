<?php

namespace App\Http\Controllers\Interval;

use App\Models\Project;
use App\Models\Category;

trait ControlIntervalTrait {

  protected $intervalValidationRules = [
    'project_id' => 'nullable|integer|exists:customers,id'
  ];

  protected $intervalCategoryValidationRules = [
    'category_id' => 'required|integer|exists:customers,id',
    'attached' => 'nullable|boolean',
  ];

  protected function getIntervalUpdateValidationRules() {
    $rules = [];
    $rules['project_id'] = $this->intervalValidationRules['project_id'];
    $rules['start_time'] = 'required|date_format:Y-m-d H:i:s';
    $rules['end_time'] = 'nullable|date_format:Y-m-d H:i:s';
    return $rules; 
  }

  protected function isProjectIdValid($user, $projectId) {
    if(! $projectId) {
      return true;
    }
    $project = Project::find($projectId);
    if(! $project) {
      return false;
    }
    return $user->can('update', $project);
  }

  protected function isCategoryIdValid($user, $category) {
    if(! $category) {
      return false;
    }
    $category = Category::find($category);
    if(! $category) {
      return false;
    }
    return $user->can('update', $category);
  }
}