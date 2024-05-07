<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'customer_id', 'user_id'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function intervals(): HasMany
    {
        return $this->hasMany(Interval::class);
    }

    public function scopeWithName($query, $name) {
        return $query->where('projects.name', 'LIKE', "%{$name}%");
    }
    
}
