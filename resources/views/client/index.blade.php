<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des Clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-row justify-between">
                    <h1>Liste des clients</h1>
                    <button class="p-2 bg-green-300 rounded-lg">
                        <a href="{{ route('client.create') }}">Ajouter un client</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
