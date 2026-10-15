<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ServiceRecordController;

Route::resource('equipment', EquipmentController::class);

// Routa pro uložení servisního záznamu k zařízení
Route::post('equipment/{equipment}/service-records', [ServiceRecordController::class, 'store'])
    ->name('service-records.store');

Route::get('/', function () {
    return redirect()->route('equipment.index');
});
