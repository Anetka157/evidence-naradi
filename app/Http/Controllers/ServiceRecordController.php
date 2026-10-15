<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class ServiceRecordController extends Controller
{
    /**
     * Uložení nového servisního záznamu k danému zařízení.
     */
    public function store(Request $request, Equipment $equipment)
    {
        // Validace dat podle zadání
        $validated = $request->validate([
            'description' => 'required|string',
            'serviced_at' => 'required|date',
            'cost' => 'required|numeric|min:0', // Nezáporné desetinné číslo
        ]);

        // Vytvoření záznamu navázaného přímo na dané zařízení
        $equipment->serviceRecords()->create($validated);

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Servisní záznam byl úspěšně přidán.');
    }
}
