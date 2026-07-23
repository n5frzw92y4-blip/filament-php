<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calendar extends Model
{
    protected $fillable = ["name","start","end","allDay"];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
