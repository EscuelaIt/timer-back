<?php

namespace App\Actions\Crud;

use App\Actions\CrudAction;

class DemoChangeEssentialAction extends CrudAction {   
    protected function validationRules() {
        return [
            'essential' => ['required', 'boolean'],
        ];
    }

    public function handle() {
        foreach($this->models as $model) {
            $model->essential = $this->data["essential"];
            $model->save();;
        }
        return $this->sendSuccess(
            "Cambiado valor essential",
            [
              'action' => "DemoChangeEssentialAction",
              'data' => [
                  
              ],
            ]
        );
    }
}