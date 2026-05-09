<?php

namespace App\Http\Controllers\BoardGame;

use App\Models\BoardGame;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Lib\Tag\TagsAssociator;
use App\Http\Controllers\Controller;

class BoardGameTagController extends Controller
{
    use ApiFeedbackSender;

    public function index($id)
    {
        $game = BoardGame::where('id', $id)->with('tags')->first();

        if (!$game) {
            return $this->sendError('No se encuentra este juego', 404);
        }

        $associator = new TagsAssociator($game);

        return $this->sendSuccess('Board game tags', $associator->getTags());
    }

    public function attach(Request $request, $id)
    {
        $game = BoardGame::find($id);

        if (!$game) {
            return $this->sendError('No se encuentra este juego', 404);
        }

        if (!$request->filled('tag_id')) {
            return $this->sendValidationError('El campo tag_id es obligatorio', ['tag_id' => ['El campo tag_id es obligatorio']]);
        }

        $associator = new TagsAssociator($game);
        $associator->attachTag((int) $request->tag_id);

        return $this->sendSuccess('Tag añadido al juego', null, 201);
    }

    public function detach($id, $tagId)
    {
        $game = BoardGame::find($id);

        if (!$game) {
            return $this->sendError('No se encuentra este juego', 404);
        }

        $associator = new TagsAssociator($game);
        $associator->detachTag((int) $tagId);

        return $this->sendSuccess('Tag eliminado del juego', null);
    }
}
