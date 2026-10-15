<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidat nové zařízení</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<div class="container mx-auto px-4 py-8 max-w-xl">
    <div class="mb-6">
        <a href="{{ route('equipment.index') }}" class="text-blue-600 hover:underline">&larr; Zpět na seznam zařízení</a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Přidat nové zařízení</h1>

        <!-- Zobrazení validačních chyb -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('equipment.store') }}" method="POST">
            @csrf

            <!-- Název zařízení -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Název zařízení:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <!-- Evidenční číslo -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="inventory_number">Evidenční číslo (unikátní):</label>
                <input type="text" name="inventory_number" id="inventory_number" value="{{ old('inventory_number') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <!-- Stav zařízení -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Stav:</label>
                <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktivní</option>
                    <option value="service" {{ old('status') == 'service' ? 'selected' : '' }}>V servisu</option>
                    <option value="retired" {{ old('status') == 'retired' ? 'selected' : '' }}>Vyřazeno</option>
                </select>
            </div>

            <!-- Datum nákupu -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="purchased_at">Datum nákupu:</label>
                <input type="date" name="purchased_at" id="purchased_at" value="{{ old('purchased_at') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <!-- Tlačítka -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Uložit zařízení
                </button>
                <a href="{{ route('equipment.index') }}" class="text-gray-600 hover:underline">Zrušit</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
