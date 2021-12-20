<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des élèves') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-row justify-between">
                    <button class="p-2 bg-green-300 rounded-lg">
                        <a href="{{ route('eleve.create') }}">Ajouter un élève</a>
                    </button>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach ($eleves as $eleve)
                        <div class="flex flex-row justify-between w-1/2 mx-auto">
                            <h2 class="text-3xl">{{ $eleve->nom }}</h2>
                            <button class="p-2 rounded-lg bg-blue-300"><a href="{{ route('eleve.show', $eleve->id) }}">Détails</a></button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
