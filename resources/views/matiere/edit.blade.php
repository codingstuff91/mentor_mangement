<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edition de matière') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('matiere.update', $matiere->id) }}" method="post" class="w-full">
                        @csrf
                        @method('patch')

                        <div class="mb-4 mx-auto w-full columns-3">
                            <label>Nom de la matière</label>
                            <input type="text" name="nom" class="rounded-lg w-full" value="{{ $matiere->nom }}"/>
                        </div>

                        <button class="bg-green-400 rounded p-2 mt-4 w-full">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
