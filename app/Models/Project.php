<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'customer_id'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    
}
