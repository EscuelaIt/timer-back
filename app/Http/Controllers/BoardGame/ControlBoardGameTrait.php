<?php

namespace App\Http\Controllers\BoardGame;

use App\Models\Country;

trait ControlBoardGameTrait {
    protected $boardGameValidationRules = [
        'slug' => 'required|string|max:100',
        'name' => 'required|string|min:2|max:250',
        'year' => 'nullable|integer',
        'country_id' => 'nullable|integer|exists:countries,id',
        'essential' => 'nullable|boolean',
    ];
}
