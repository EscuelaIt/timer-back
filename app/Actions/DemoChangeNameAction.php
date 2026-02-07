<?php

namespace App\Actions;

use EscuelaIT\APIKit\ActionResult;
use EscuelaIT\APIKit\CrudAction;

class DemoChangeNameAction extends CrudAction
{
    protected function validationRules(): array {
        return [
            'name' => 'required|string|max:250'
        ];
    }

    public function handle(): ActionResult
    {
        foreach($this->models as $model) {
            $model->name = $this->data['name'];
            $model->save();
        }
        return $this->createActionResultSuccess('Action completed', [

        ]);
    }
}
