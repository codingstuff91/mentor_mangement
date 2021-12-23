<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ $facture->client->nom }} | {{ $facture->month_year_creation }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row">
            <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-gray-300 w-1/3">
                <h2 class="text-3xl text-center">Nombre heures : {{ $total_heures }}</h2>
            </div>
            <div class="ml-4 p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-gray-300 w-2/3">
                <h2 class="p-2 text-3xl text-center">Cours concernés</h2>
                @foreach ($cours as $lecon)
                <div class="my-2 p-2 bg-white shadow-sm sm:rounded-lg border-2 border-gray-300 flex justify-between">
                        <p><i class="fas fa-user mr-2"></i>{{ $lecon->eleve->nom }}</p>
                        <p><i class="fas fa-calendar-day mr-2"></i>le {{ $lecon->date_formated }}</p>
                        <p><i class="fas fa-clock mr-2"></i>{{ $lecon->heure_debut }} --> {{ $lecon->heure_fin }}</p>
                        <p>{{ $lecon->nombre_heures }} heure{{ $lecon->nombre_heures > 1 ? "s" : "" }}</p>
                        <p><i class="fas fa-euro-sign mr-2"></i>{{ $lecon->total_prix }}€</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
