<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des cours') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">
                    <button class="p-2 bg-green-300 rounded-lg">
                        <a href="{{ route('cours.create') }}">Ajouter un cours</a>
                    </button>
                </div>
            </div>

            @foreach ($cours as $lecon)
            <div class="mt-2 w-1/2">
                <div class="p-2 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg flex justify-between">
                    <div class="flex flex-col">
                        <h1 class="text-lg font-extrabold">{{ $lecon->date_formated }} | {{ $lecon->heure_debut }} --> {{ $lecon->heure_fin }} | {{ $lecon->nombre_heures }} heure{{ $lecon->nombre_heures > 1 ? "s" : "" }}</h1>
                        <p class="mt-2">{!! $lecon->notions_apprises !!}</p>
                    </div>
                    <div class="flex flex-row h-1/2">
                        <button class="text-xs p-2 rounded-lg bg-blue-300"><a href="{{ route('cours.edit', $lecon->id) }}">Editer</a></button>
                        <button class="text-xs p-2 rounded-lg bg-red-300 ml-2">Supprimer</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>