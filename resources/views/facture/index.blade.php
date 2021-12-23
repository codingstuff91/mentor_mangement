<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des factures') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200 flex flex-row justify-between">
                    <button class="p-2 bg-green-300 rounded-lg">
                        <a href="{{ route('facture.create') }}">Créer une facture</a>
                    </button>
                </div>
            </div>
            <div class="mt-4 w-1/2 mx-auto p-2 bg-white border-b border-gray-200">
                @foreach ($factures as $facture)
                    <div class="my-4 flex flex-row justify-between w-2/3 mx-auto">
                        <h2 class="text-3xl flex items-center">{{ $facture->id }}</h2>
                        <h3 class="text-xl flex items-center">{{ $facture->created_at }}</h3>
                        <h3 class="text-xl flex items-center">{{ $facture->payee ? "OUI":"NON" }}</h3>
                        <button>
                            <a href="{{ route('facture.edit', $facture->id) }}" class="p-2 rounded-lg bg-blue-300">Editer</a>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
