<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function intervals(): BelongsToMany
    {
        return $this->belongsToMany(Interval::class);
    }

    public function getHasRelatedDataAttribute() {
        if($this->intervals()->exists()) {
            return true;
        }
        return false;
    }
}
