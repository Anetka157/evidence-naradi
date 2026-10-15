<?php

namespace App\Models; // Opravte si namespace na App\Http\Controllers; pokud ho Laravel nevygeneroval správně
namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Zobrazení seznamu zařízení s možností filtru podle stavu.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');

        $query = Equipment::query();

        // Filtr podle stavu (active, service, retired)
        if (in_array($status, ['active', 'service', 'retired'])) {
            $query->where('status', $status);
        }

        $equipments = $query->with('serviceRecords')->latest()->get();

        return view('equipment.index', compact('equipments', 'status'));
    }

    /**
     * Zobrazení formuláře pro vytvoření nového zařízení.
     */
    public function create()
    {
        return view('equipment.create');
    }

    /**
     * Uložení nového zařízení do databáze včetně validace.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'inventory_number' => 'required|string|unique:equipment,inventory_number',
            'status' => 'required|in:active,service,retired',
            'purchased_at' => 'required|date',
        ]);

        Equipment::create($validated);

        return redirect()->route('equipment.index')->with('success', 'Zařízení bylo úspěšně přidáno.');
    }

    /**
     * Zobrazení detailu zařízení včetně servisní historie.
     */
    public function show(Equipment $equipment)
    {
        $equipment->load('serviceRecords');
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Zobrazení formuláře pro úpravu zařízení.
     */
    public function edit(Equipment $equipment)
    {
        return view('equipment.edit', compact('equipment'));
    }

    /**
     * Aktualizace existujícího zařízení v databázi.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'inventory_number' => 'required|string|unique:equipment,inventory_number,' . $equipment->id,
            'status' => 'required|in:active,service,retired',
            'purchased_at' => 'required|date',
        ]);

        $equipment->update($validated);

        return redirect()->route('equipment.index')->with('success', 'Zařízení bylo úspěšně aktualizováno.');
    }

    /**
     * Smazání zařízení z databáze.
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('equipment.index')->with('success', 'Zařízení bylo smazáno.');
    }
}
