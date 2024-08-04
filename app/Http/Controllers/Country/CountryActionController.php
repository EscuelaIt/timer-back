<?php

namespace App\Http\Controllers\Country;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CountryActionController extends Controller
{
    use ApiFeedbackSender;
    
    private $models;
    
    public function handleAction(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'type' => ['required', 'string', 'max:250'],
            'relatedIds' => ['required', 'array'],
            'data' => ['present'],
        ]);
        if($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $this->models = Country::whereIn('id', $request->relatedIds)->get();

        if($request->type == 'DeleteAction') {
            return $this->handle();
        } else {
            return $this->sendError('Acción no válida para países');   
        }
    }

    public function handle() {
        $numDeleted = 0;
        $deleteElems = []; 
        foreach($this->models as $model) {
            info('Deleting model: ' . $model->id);
            $model->boardGames()->update(['country_id' => null]);
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
