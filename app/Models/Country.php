<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'continent'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function boardGames() {
        return $this->hasMany(BoardGame::class);
    }
}
