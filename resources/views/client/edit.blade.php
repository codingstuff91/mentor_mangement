<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edition de client') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="w-full mx-auto sm:w-3/4 sm:px-6 lg:w-2/3 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('client.update', $client->id) }}" method="post" class="w-full">
                        @csrf
                        @method('patch')

                        <div class="mb-4 mx-auto">
                            <label>Nom du client</label>
                            <input type="text" name="nom" class="rounded-lg w-full" value="{{ $client->nom }}"/>
                        </div>
                        
                        <div class="w-full my-4">
                            <label class="block">Commentaires</label>
                            <textarea class="block rounded-lg w-full" name="commentaires" cols="4" rows="2">{{ $client->commentaires }}</textarea>
                        </div>

                        <button class="bg-green-400 rounded p-2 mt-4 w-full">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
