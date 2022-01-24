<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editer un cours') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="w-1/3 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg drop-shadow-xl">
                <div class="p-6 bg-white border-b border-gray-200 flex flex-row justify-between">
                    <form action="{{ route('cours.update', $cours->id) }}" method="post" class="flex flex-col">
                        @csrf
                        @method('patch')

                        <label>Date du cours</label>
                        <input type="date" name="date_debut" value="{{ $cours->date_debut_edited }}" class="rounded-lg mt-2">

                        <label class="mt-2">Heure début</label>
                        <input type="time" class="rounded-lg" name="heure_debut" value="{{ $cours->heure_debut }}">
                        
                        <label class="mt-2">Heure fin</label>
                        <input type="time" class="rounded-lg" name="heure_fin" value="{{ $cours->heure_fin }}">

                        <label class="mt-2">Cours payé</label>
                        <select class="mt-2" name="paye" class="rounded-lg" value="{{ $cours->paye }}">
                            <option value="0" @if ($cours->paye == 0) selected="selected" @endif>NON</option>
                            <option value="1" @if ($cours->paye == 1) selected="selected" @endif>OUI</option>
                        </select>

                        <input type="submit" value="Editer le cours" class="p-2 mt-4 rounded-lg bg-green-400">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
