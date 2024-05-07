<?php

namespace App\Http\Controllers\Interval;

use App\Models\Project;
use App\Models\Category;

trait ControlIntervalTrait {

  protected $intervalValidationRules = [
    'project_id' => 'nullable|integer|exists:projects,id',
    'start_time' => 'nullable|date_format:Y-m-d H:i:s',
    'end_time' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_time',
  ];

  protected $intervalCategoryValidationRules = [
    'category_id' => 'required|integer|exists:categories,id',
    'attached' => 'nullable|boolean',
  ];

  protected function getIntervalUpdateValidationRules() {
    $rules = [];
    $rules['project_id'] = $this->intervalValidationRules['project_id'];
    $rules['start_time'] = 'required|date_format:Y-m-d H:i:s';
    $rules['end_time'] = $this->intervalValidationRules['end_time'];
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