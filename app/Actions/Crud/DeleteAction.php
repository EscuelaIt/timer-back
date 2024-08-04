<?php

namespace App\Actions\Crud;

use App\Actions\CrudAction;

class DeleteAction extends CrudAction {   
    public function handle() {
        info('handle');
        $numDeleted = 0;
        $deleteElems = []; 
        foreach($this->models as $model) {
            info('borrando el modelo model: ' . $model->id);
            if (method_exists($model, 'cleanModelTask')) {
                info('invocar tareas de limpieza');
                $model->cleanModelTask();
            } else {
                info('no encontré el método');
            }
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