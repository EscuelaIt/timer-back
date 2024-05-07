<?php

namespace App\Http\Controllers\Project;

use App\Models\Customer;

trait ControlProjectTrait {
  protected $projectValidationRules = [
        'name' => 'required|string|min:2|max:100',
        'description' => 'nullable|string|max:1000',
        'customer_id' => 'nullable|integer|exists:customers,id'
  ];

  protected function isCustomerIdValid($user, $customerId) {
    if($customerId) {
      $customer = Customer::find($customerId);
      if(! $customer) {
        return false;
      }
      return $user->can('update', $customer);
    }
    return true;
  }
}