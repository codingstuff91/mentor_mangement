<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ $eleve->nom }}
        </h2>
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ $eleve->matiere->nom }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row">
            <div class="p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-gray-300 w-1/3">
                <h2 class="text-3xl text-center">Objectifs</h2>
                <p class="my-2 text-center">{!! $eleve->objectifs !!}</p>
            </div>
            <div class="ml-4 p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-gray-300 w-2/3">
                <h2 class="p-2 text-3xl text-center">Cours réalisés</h2>
                <div class="ml-2 p-2 bg-white shadow-sm sm:rounded-lg border-2 border-gray-300">
                    @foreach ($eleve->cours as $cours)
                        <div class="my-2 flex flex-row justify-between mx-auto w-1/2">
                            <p><i class="fas fa-calendar-day mr-2"></i>{{ $cours->date_formated }} | <i class="fas fa-clock"></i> {{ $cours->heure_debut }} --> {{ $cours->heure_fin }}</p>
                            <p>{{ $cours->nombre_heures }} Heure{{ $cours->nombre_heures > 1 ? "s" : ""}}</p>
                        </div>
                        <div class="flex flex-col justify-center w-full">
                            <h2 class="text-2xl text-center">Notions travaillées : </h2>
                            <p class="text-xl text-center">{!! $cours->notions_apprises !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
