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
                    <h1 class="text-2xl">Liste des clients</h1>
                    <button class="p-2 bg-green-300 rounded-lg">
                        <a href="{{ route('client.create') }}">Ajouter un client</a>
                    </button>
                </div>
                <div class="p-4 bg-white border-b border-gray-200">
                    @foreach ($clients as $client)
                        <div class="flex justify-between my-4 w-3/4 mx-auto">
                            <div>
                                <h2 class="text-xl">{{ $client->nom }}</h2>
                                <p class="ml-6">{{ $client->commentaires }}</p>
                            </div>
                            <div>
                                <button class="p-2 bg-blue-300 rounded-lg"><a href="{{ route('client.edit', $client->id) }}">Editer</a></button>
                                <button class="p-2 bg-red-300 rounded-lg"><a href="{{ route('client.destroy', $client->id) }}">Supprimer</a></button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
