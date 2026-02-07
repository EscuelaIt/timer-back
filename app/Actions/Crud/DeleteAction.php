<?php

namespace App\Actions\Crud;

use EscuelaIT\APIKit\CrudAction;
use EscuelaIT\APIKit\ActionResult;

class DeleteAction extends CrudAction {
    public function handle(): ActionResult {
        $numDeleted = 0;
        $deleteElems = [];
        foreach($this->models as $model) {
            $model->delete();
            $deleteElems[] = $model->id;
            $numDeleted++;
        }
        $message = ($numDeleted == 1 ? 'Borrado' : 'Borrados') . " $numDeleted " . ($numDeleted == 1 ? 'elemento' : 'elementos') . " con éxito";
        return $this->createActionResultSuccess($message, [
            'delete_count' => $numDeleted,
            'delete_elems' => $deleteElems,
        ]);
    }
}
