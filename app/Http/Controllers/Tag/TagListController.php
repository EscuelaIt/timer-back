<?php

namespace App\Http\Controllers\Tag;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Lib\ApiFeedbackSender;
use App\Http\Controllers\Controller;

class TagListController extends Controller
{
    use ApiFeedbackSender;

    public function index(Request $request)
    {
        $tags = Tag::orderBy('name', 'asc')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->get();

        return $this->sendSuccess('Tags', $tags);
    }
}
