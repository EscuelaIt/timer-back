<?php

namespace App\Http\Controllers\Country;

use Illuminate\Validation\Rule;

trait ControlCountryTrait {
  protected function countryValidationRules() {
    $continents = ['Europe', 'South America', 'Asia', 'Africa', 'Oceania', 'North America'];
    return [
        'name' => 'required|string|min:2|max:100',
        'slug' => 'required|string|min:2|max:100',
        'continent' => ['required', 'string', Rule::in($continents)],
    ];   
  }
}