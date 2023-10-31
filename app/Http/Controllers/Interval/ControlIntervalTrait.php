<?php

namespace App\Http\Controllers\Interval;

use App\Models\Project;

trait ControlIntervalTrait {
  protected $intervalValidationRules = [
    'project_id' => 'nullable|integer|exists:customers,id'
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
}