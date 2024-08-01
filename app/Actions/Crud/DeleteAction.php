<?php

namespace App\Actions\Crud;

use App\Actions\CrudAction;

class DeleteAction extends CrudAction {   
    public function handle() {
        $numDeleted = 0;
        $deleteElems = []; 
        foreach($this->models as $model) {
            info('Deleting model: ' . $model->id);
            $model->delete();
            $deleteElems[] = $model->id;
            $numDeleted++;
        }
        return $this->sendSuccess(
            "Borrados $numDeleted " . ($numDeleted == 1 ? 'elemento' : 'elementos') . " con éxito",
            [
              'action' => "DeleteAction",
              'data' => [
                  'delete_count' => $numDeleted,
                  'delete_elems' => $deleteElems,
              ],
            ]
        );
    }
}