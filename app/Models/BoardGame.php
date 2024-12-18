<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BoardGame extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name', 'year', 'country_id', 'essential'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function mechanics(): BelongsToMany
    {
        return $this->belongsToMany(Mechanic::class);
    }

    /////////////////////////////////
    // SCOPES
    /////////////////////////////////

    public function scopeSimilar($query, $keyword) {
        if(!$keyword) {
            return $query;
        }
        return $query->where(function($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        });
    }

    public function scopeIsEssential($query) {
        return $query->where('essential', true);
    }

    public function scopeFromCountry($query, $countryId) {
        return $query->where('country_id', $countryId);
    }
}


