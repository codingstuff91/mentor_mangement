<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des cours') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-row justify-between">
                    <button class="p-2 bg-green-300 rounded-lg">
                        <a href="{{ route('cours.create') }}">Ajouter un cours</a>
                    </button>
                </div>
            </div>
            <div class="my-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach ($cours as $lecon)
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1>{{ $lecon->date_debut }} | {{ $lecon->nombre_heures }} heures</h1>
                        <p>{!! $lecon->notions_apprises !!}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>