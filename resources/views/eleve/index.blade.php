<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des élèves') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200 flex flex-row justify-between">
                    <button class="p-2 bg-green-300 rounded-lg">
                        <a href="{{ route('eleve.create') }}">Ajouter un élève</a>
                    </button>
                </div>
            </div>
            <div class="mt-4 w-full mx-auto p-2 bg-white border-b border-gray-200">
                @foreach ($eleves as $eleve)
                    <div class="my-4 flex flex-row justify-between w-3/4 mx-auto">
                        <h2 class="text-3xl flex items-center">{{ $eleve->nom }}
                            @if ($eleve->active)
                                <span class="ml-2 p-2 text-xs rounded-lg bg-green-200"><i class="fas fa-check mr-2"></i>Actif</span>
                            @else
                                <span class="ml-2 p-2 text-xs rounded-lg bg-red-100"><i class="fas fa-ban mr-2"></i>Inactif</span>
                            @endif
                            
                            <span class="ml-2 p-2 text-xs rounded-lg bg-blue-100"><i class="fas fa-user mr-2"></i>{{ $eleve->client->nom }}</span>
                            <span class="ml-2 p-2 text-xs rounded-lg bg-amber-300"><i class="fas fa-book mr-2"></i>{{ $eleve->matiere->nom }}</span>
                        </h2>
                        <button class="p-2 rounded-lg bg-blue-300"><a href="{{ route('eleve.show', $eleve->id) }}"><i class="fas fa-search mr-2"></i>Détails</a></button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
