<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    protected $table = 'equipment';

    protected $fillable = [
        'name',
        'inventory_number',
        'status',
        'purchased_at',
    ];

    // Vztah: Zařízení má mnoho servisních záznamů
    public function serviceRecords(): HasMany
    {
        return $this->hasMany(ServiceRecord::class);
    }

    // Pomocná metoda pro součet servisních nákladů
    public function getTotalServiceCostAttribute()
    {
        return $this->serviceRecords()->sum('cost');
    }
}
