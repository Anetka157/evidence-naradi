<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evidence nářadí</title>
    <!-- Tailwind CSS CDN pro rychlé otestování -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Evidence firemního nářadí</h1>
        <a href="{{ route('equipment.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Přidat zařízení
        </a>
    </div>

    <!-- Úspěšná hlášení -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Filtry podle stavu -->
    <div class="mb-4 flex space-x-2">
        <a href="{{ route('equipment.index') }}" class="px-4 py-2 rounded {{ !request('status') ? 'bg-gray-800 text-white' : 'bg-white text-gray-700 border' }}">Všechna</a>
        <a href="{{ route('equipment.index', ['status' => 'active']) }}" class="px-4 py-2 rounded {{ request('status') == 'active' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 border' }}">Aktivní</a>
        <a href="{{ route('equipment.index', ['status' => 'service']) }}" class="px-4 py-2 rounded {{ request('status') == 'service' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-700 border' }}">V servisu</a>
        <a href="{{ route('equipment.index', ['status' => 'retired']) }}" class="px-4 py-2 rounded {{ request('status') == 'retired' ? 'bg-red-600 text-white' : 'bg-white text-gray-700 border' }}">Vyřazeno</a>
    </div>

    <!-- Tabulka zařízení -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Název</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Evidenční číslo</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stav</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Datum nákupu</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Akce</th>
            </tr>
            </thead>
            <tbody>
            @forelse($equipments as $item)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <a href="{{ route('equipment.show', $item) }}" class="text-blue-600 hover:underline font-semibold">{{ $item->name }}</a>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $item->inventory_number }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <!-- Barevně a textově rozlišený stav -->
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
                        <span class="px-3 py-1 text-xs font-semibold rounded-full border {{ $statusClasses[$item->status] ?? '' }}">
                                    {{ $statusLabels[$item->status] ?? $item->status }}
                                </span>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $item->purchased_at }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right space-x-2">
                        <a href="{{ route('equipment.show', $item) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                        <a href="{{ route('equipment.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900">Upravit</a>
                        <form action="{{ route('equipment.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Opravdu chcete smazat toto zařízení?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Smazat</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-5 text-center text-gray-500">Žádná zařízení nebyla nalezena.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
