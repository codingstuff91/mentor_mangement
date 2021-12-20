<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajout nouvel eleve') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-xl text-center">Ajout d'un élève</h1>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('eleve.store') }}" method="post" class="w-full">
                        @csrf
                        <div class="mb-4 mx-auto w-full columns-3">
                            <label>Nom de l'élève</label>
                            <input type="text" name="nom" class="rounded-lg w-full"/>

                            <label>Matière</label>
                            <select name="matiere" class="rounded-lg w-full">
                                <option value="">-- Choisir une matère --</option>
                                <option value="excel">Excel</option>
                                <option value="laravel">Laravel</option>
                            </select>
                            
                            <label>Client</label>
                            <select name="client" class="rounded-lg w-full">
                                <option value="">-- Choisir un client --</option>
                                <option value="superprof">Superprof</option>
                                <option value="superprof">Orformat</option>
                            </select>
                        </div>
                        <div class="w-full my-4">
                            <label>Objectifs</label>
                            <textarea class="block rounded-lg w-full" name="objectifs" cols="4" rows="2"></textarea>
                        </div>
                        <div class="w-full my-4">
                            <label class="block">Commentaires</label>
                            <textarea class="block rounded-lg w-full" name="commentaires" cols="4" rows="2"></textarea>
                        </div>

                        <button class="bg-green-400 rounded p-2 mt-4 w-full">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
