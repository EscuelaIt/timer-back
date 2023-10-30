<?php

namespace App\Http\Controllers\Project;

trait ControlProjectTrait {
  protected $projectValidationRules = [
        'name' => 'required|string|min:2|max:100',
        'description' => 'nullable|string|max:1000',
        'customer_id' => 'required|integer|exists:customers,id'
    ];
}