<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des factures') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-2 flex flex-row justify-center">
                    <button class="p-2 bg-blue-600 rounded-lg text-white text-xl">
                        <i class="fas fa-plus mr-2"></i>
                        <a href="{{ route('facture.create') }}">Créer une facture</a>
                    </button>
                </div>
            </div>
            <div class="mt-4 w-full">
                @foreach ($factures as $facture)
                    <div class="my-4 p-4 bg-white">
                        <div class="flex justify-center columns-3 gap-4">
                            <h2 class="p-2 bg-lime-300 rounded-lg"><i class="fas fa-user mr-2"></i>{{ $facture->client->nom }}</h2>
                            <h3 class="ml-2 p-2 bg-blue-600 text-white rounded-lg"><i class="fas fa-calendar-day mr-2"></i>{{ $facture->month_year_creation }}</h3>
                            @if ($facture->payee)
                                <p class="text-xl bg-green-600 text-white p-2 rounded-lg font-bold">{{ $facture->total }}€</p>
                            @else
                                <p class="text-xl bg-red-600 text-white p-2 rounded-lg font-bold">{{ $facture->total }}€</p>
                            @endif
                        </div>
                        <div class="mt-4 flex justify-around">
                            <button>
                                <a href="{{ route('facture.show', $facture->id) }}" class="p-2 rounded-lg bg-blue-300"><i class="fas fa-search mr-2"></i>Détails</a>
                            </button>
                            <button>
                                <a href="{{ route('facture.edit', $facture->id) }}" class="p-2 rounded-lg bg-cyan-300"><i class="fas fa-edit mr-2"></i>Mettre à jour</a>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
