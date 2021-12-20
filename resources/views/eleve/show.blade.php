<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ $eleve->nom }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-2 p-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="text-3xl text-center">Cours réalisés</h2>
            </div>
        </div>
    </div>
</x-app-layout>
