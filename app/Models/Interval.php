<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Interval extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'project_id', 'start_time'];

    protected $appends = ['start_time_utc', 'end_time_utc'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function getStartTimeUtcAttribute() {
        return $this->start_time->format('Y-m-d H:i:s');
    }

    public function getEndTimeUtcAttribute() {
        if($this->end_time) {
            return $this->end_time->format('Y-m-d H:i:s');
        }
        return '';
    }
}
