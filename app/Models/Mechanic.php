<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mechanic extends Model
{
    use HasFactory;

    /* RELATIONS */

    public function BoardGames(): BelongsToMany
    {
        return $this->belongsToMany(BoardGame::class);
    }

}
