<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des Clients') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    @foreach ($clients as $client)
                        <div class="flex justify-between my-4 w-1/2 mx-auto">
                            <div>
                                <h2 class="text-xl">{{ $client->nom }}</h2>
                                <p class="ml-6">{{ $client->commentaires }}</p>
                            </div>
                            <div class="flex flex-row items-center">
                                <button class="p-2 bg-blue-300 rounded-lg mr-2"><a href="{{ route('client.edit', $client->id) }}">Editer</a></button>
                                <form action="{{ route('client.destroy', $client->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="bg-red-400 p-2 rounded-lg" type="submit">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
