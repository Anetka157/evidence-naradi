<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRecord extends Model
{
    protected $fillable = [
        'equipment_id',
        'description',
        'serviced_at',
        'cost',
    ];

    // Vztah: Servisní záznam patří k jednomu zařízení
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
