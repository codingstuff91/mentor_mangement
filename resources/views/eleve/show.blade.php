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
        <h2 class="text-2xl font-bold text-center mb-2">Objectifs</h2>
        <div class="w-full p-4 bg-white border-b border-gray-400 mb-4">
            <p class="my-2 text-center text-lg">{!! $eleve->objectifs !!}</p>
        </div>

        <h2 class="text-2xl font-bold text-center mt-4 mb-2">{{ $eleve->cours_count }} Cours réalisés</h2>
        @foreach ($eleve->cours as $cours)
            <div class="p-2 bg-white shadow-sm border-b border-gray-400 w-full my-4 mx-auto sm:w-3/4">
                <div class="my-2 flex flex-col justify-between">
                    <p><i class="fas fa-calendar-day mr-2"></i>{{ $cours->date_formated }}</p>
                    <p><i class="fas fa-clock"></i> {{ $cours->heure_debut }} --> {{ $cours->heure_fin }} ({{ $cours->nombre_heures }}heure{{ $cours->nombre_heures > 1 ? "s" : ""}})</p>
                </div>
                <div class="flex flex-col w-full">
                    <h2 class="text-xl font-bold">Notions travaillées : </h2>
                    <p class="text-lg">{!! $cours->notions_apprises !!}</p>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
