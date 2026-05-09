<?php

namespace App\Http\Controllers\Tag;

use App\Models\Tag;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;

class TagListController extends Controller
{
    use ApiFeedbackSender;

    public function index()
    {
        $tags = Tag::orderBy('name', 'asc')->get();

        return $this->sendSuccess('Tags', $tags);
    }
}
