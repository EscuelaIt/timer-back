<?php

namespace App\Http\Controllers\Category;

trait ControlCategoryTrait {
  protected $categoryValidationRules = [
        'name' => 'required|string|min:2|max:50',
  ];
}