<?php

namespace App\Lib\Tag;

use App\Models\Tag;

class TagsAssociator
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getTags(): \Illuminate\Support\Collection
    {
        $attachedIds = $this->model->tags->pluck('id');
        $tags = Tag::orderBy('name', 'asc')->get();

        return $tags->map(fn ($tag) => [
            'id'      => $tag->id,
            'label'   => $tag->name,
            'slug'    => $tag->slug,
            'checked' => $attachedIds->contains($tag->id),
        ]);
    }

    public function attachTag(int $tagId): void
    {
        $this->model->tags()->syncWithoutDetaching([$tagId]);
    }

    public function detachTag(int $tagId): void
    {
        $this->model->tags()->detach($tagId);
    }
}
