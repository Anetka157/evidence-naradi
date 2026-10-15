<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail zařízení: {{ $equipment->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('equipment.index') }}" class="text-blue-600 hover:underline">&larr; Zpět na seznam zařízení</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Karta s detailem zařízení -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $equipment->name }}</h1>
                <p class="text-gray-600">Evidenční číslo: <span class="font-semibold">{{ $equipment->inventory_number }}</span></p>
                <p class="text-gray-600">Datum nákupu: {{ $equipment->purchased_at }}</p>
            </div>
            <div>
                @php
                    $statusClasses = [
                        'active' => 'bg-green-100 text-green-800 border-green-300',
                        'service' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                        'retired' => 'bg-red-100 text-red-800 border-red-300',
                    ];
                    $statusLabels = [
                        'active' => 'Aktivní',
                        'service' => 'V servisu',
                        'retired' => 'Vyřazeno',
                    ];
                @endphp
                <span class="px-3.py-1 text-sm font-semibold rounded-full border {{ $statusClasses[$equipment->status] }}">
                        {{ $statusLabels[$equipment->status] }}
                    </span>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
            <div>
                <span class="text-gray-700 font-semibold">Celkové náklady na servis:</span>
                <span class="text-xl font-bold text-red-600">{{ number_format($equipment->total_service_cost, 2, ',', ' ') }} Kč</span>
            </div>
        </div>
    </div>

    <!-- Dva sloupce: Historie a Přidání servisu -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Seznam servisních záznamů -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Historie servisních zásahů</h2>

            @if($equipment->serviceRecords->count() > 0)
                <div class="space-y-4">
                    @foreach($equipment->serviceRecords as $record)
                        <div class="border-b pb-3">
                            <p class="text-gray-800"><strong>Popis:</strong> {{ $record->description }}</p>
                            <p class="text-sm text-gray-500">Datum: {{ $record->serviced_at }} | Cena: <strong>{{ number_format($record->cost, 2, ',', ' ') }} Kč</strong></p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Zatím neproběhl žádný servis.</p>
            @endif
        </div>

        <!-- Formulář pro přidání servisního záznamu -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Přidat servisní záznam</h2>

            <form action="{{ route('service-records.store', $equipment) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Popis servisu:</label>
                    <textarea name="description" id="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="serviced_at">Datum servisu:</label>
                    <input type="date" name="serviced_at" id="serviced_at" value="{{ old('serviced_at') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="cost">Cena (Kč):</label>
                    <input type="number" step="0.01" min="0" name="cost" id="cost" value="{{ old('cost') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Uložit servisní záznam
                </button>
            </form>
        </div>

    </div>
</div>

</body>
</html>
