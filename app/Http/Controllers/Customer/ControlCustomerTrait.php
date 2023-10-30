<?php

namespace App\Http\Controllers\Customer;

trait ControlCustomerTrait {
  protected $customerValidationRules = [
        'name' => 'required|string|min:2|max:150',
        'email' => 'nullable|email|max:200',
        'telephone' => 'nullable|string|max:50'
    ];
}