<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ $eleve->nom }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 columns-2">
            <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="text-3xl text-center">Cours réalisés</h2>
                @foreach ($eleve->cours as $cours)
                    <div class="my-2 flex flex-row justify-between mx-auto w-2/3">
                        <p>{{ $cours->date_formated }} | {{ $cours->heure_debut }} --> {{ $cours->heure_fin }}</p>
                        <p>{{ $cours->nombre_heures }} Heure{{ $cours->nombre_heures > 1 ? "s" : ""}}</p>
                    </div>
                @endforeach
            </div>
            <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="text-3xl text-center">Objectifs</h2>
                <p class="my-2 text-center">{!! $eleve->objectifs !!}</p>
            </div>
        </div>
    </div>
</x-app-layout>
