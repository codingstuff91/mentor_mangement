<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ERREUR
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl text-red-500">Mauvais format des heures de début et de fin de cours</h1>
                    <h2 class="mt-4">L'heure du début de cours doit être inférieure à celle de fin de cours</h2>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
