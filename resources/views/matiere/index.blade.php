<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des matières') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200 flex flex-row justify-between">
                    <button class="p-2 bg-green-300 rounded-lg">
                        <a href="{{ route('matiere.create') }}">Ajouter une matière</a>
                    </button>
                </div>
            </div>
            <div>
                @foreach ($matieres as $matiere)
                    <div class=" w-1/2 mx-auto mt-2 p-4 bg-white flex justify-between">
                        <p>{{ $matiere->nom }}</p>
                        <div class="flex flex-row">
                            <button class="p-2 text-xs rounded-lg bg-blue-300"><a href="{{ route('matiere.edit',$matiere->id) }}">Editer</a></button>
                            <form action="{{ route('matiere.destroy', $matiere->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="ml-2 text-xs bg-red-400 p-2 rounded-lg" type="submit" onclick="confirm('etes vous sur de vouloir supprimer ?')">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
