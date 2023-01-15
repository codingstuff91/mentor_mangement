<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editer un eleve') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="w-1/3 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg drop-shadow-xl">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-row justify-between">
                    <form action="{{ route('eleve.update', $eleve->id) }}" method="post" class="flex flex-col">
                        @csrf
                        @method('patch')

                        <label>Nom de l'élève</label>
                        <input type="text" name="nom" value="{{ $eleve->nom }}" class="rounded-lg mt-2">

                        <label class="mt-2">Statut élève</label>
                        <select class="mt-2" name="active" class="rounded-lg" value="{{ $eleve->active }}">
                            <option value="0" @if ($eleve->active == 0) selected="selected" @endif>INACTIF/VE</option>
                            <option value="1" @if ($eleve->active == 1) selected="selected" @endif>ACTIF/VE</option>
                        </select>
                        
                        <label class="mt-2">Matiere concernée</label>
                        <select class="mt-2" name="matiere_id" class="rounded-lg">
                            @foreach ($matieres as $matiere)
                                <option value="{{ $matiere->id}}" @if ($matiere->id == $eleve->matiere_id) selected="selected" @endif>{{ $matiere->nom }}</option>
                            @endforeach
                        </select>
                        
                        <label class="mt-2">Client concerné</label>
                        <select class="mt-2" name="client_id" class="rounded-lg">
                            @foreach ($clients as $client)
                                <option value="{{ $client->id}}" @if ($client->id == $eleve->client_id) selected="selected" @endif>{{ $client->nom }}</option>
                            @endforeach
                        </select>
                        
                        <input type="submit" value="Confirmer" class="p-2 mt-4 rounded-lg bg-green-400">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
