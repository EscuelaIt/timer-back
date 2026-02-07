<?php

namespace App\Actions\Crud;

use EscuelaIT\APIKit\ActionResult;
use EscuelaIT\APIKit\CrudAction;

class DemoChangeEssentialAction extends CrudAction {
    protected function validationRules(): array {
        return [
            'essential' => ['required', 'boolean'],
        ];
    }

    public function handle(): ActionResult {
        foreach($this->models as $model) {
            $model->essential = $this->data["essential"];
            $model->save();;
        }
        return $this->createActionResultSuccess('Cambiado valor essential');
    }
}
