<?php

namespace App\Lib;

use Carbon\Carbon;

class DateTimeManager {
  private $now;

  public function __construct() {
    $this->now = Carbon::now('UTC');
  }

  public function getNow() {
    return $this->now;
  }

  public function createFromFormat($formated) {
    return Carbon::createFromFormat('Y-m-d H:i:s', $formated);
  }
}