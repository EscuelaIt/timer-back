<?php

namespace App\Lib\Crud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait ActionHandler {

    public function handleAction(Request $request) {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string', 'max:250'],
            'relatedIds' => ['required', 'array'],
            'data' => ['present'],
        ]);
        if($validator->fails()) {
            return $this->sendValidationError($validator->errors()->first());
        }

        if(! isset($this->actionTypes[$request->type])) {
            return $this->sendValidationError('Tipo de acción no válida.');
        }
        
        $models = $this->queryModels($request->relatedIds);
        $actionClass = $this->actionTypes[$request->type];
        $action = new $actionClass($models, $request->data, $user);
        return $action->processAction();
    }

    protected function queryModels($relatedIds) {
        return $this->getActionModel()::whereIn('id', $relatedIds)->get();
    }
}