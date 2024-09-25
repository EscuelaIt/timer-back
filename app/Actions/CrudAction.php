<?php

namespace App\Actions;

use App\Lib\ApiFeedbackSender;
use Illuminate\Support\Facades\Validator;

abstract class CrudAction {
    use ApiFeedbackSender;

    protected $models;
    protected $data;
    protected $user;

    public function __construct($models, $data, $user) {
        $this->models = $models;
        $this->data = $data;
        $this->user = $user;
    }
    
    abstract public function handle();
    
    public function processAction() {
        $validationResult = $this->validate();
        if( $validationResult === true) {
            return $this->handle();
        } else {
            return $this->sendError($validationResult, 422);
        }
    }

    protected function validationRules() {
        return [];
    }

    protected function validate() {
        info($this->data);
        info($this->validationRules());
        $validator = Validator::make($this->data, $this->validationRules());
        if($validator->fails()) {
            return $validator->errors()->first();
        }
        return true;
    }
}