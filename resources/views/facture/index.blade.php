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
                        <a href="{{ route('facture.create') }}">Ajouter une facture</a>
                    </button>
                </div>
            </div>
            <div class="mt-4 w-full">
                @foreach ($factures as $facture)
                    <div class="my-4 p-4 bg-white">
                        <div>
                            <h2 class="p-2 bg-gray-300 rounded-lg text-center font-bold text-lg">
                                <i class="fas fa-user mr-2"></i>
                                {{ $facture->customer->nom }}
                                ---
                                <i class="fas fa-calendar-day mx-2"></i>
                                {{ $facture->month_year_creation }}
                            </h2>
                        </div>
                        <div class="mt-4 flex justify-center items-center columns-2 gap-4">
                            <p class="text-lg bg-green-600 text-white p-2 rounded-lg font-bold">{{ $facture->total }} €</p> 
                                
                            @if ($facture->payee)
                                <p class="text-lg bg-green-200 p-2 rounded-lg font-bold">
                                    <i class="fas fa-dollar-sign"></i>
                                    Payée
                                </p>
                            @else
                                <p class="text-sm bg-red-300 p-2 rounded-lg font-bold">
                                    <i class="fas fa-dollar-sign"></i>
                                    Non payée
                                </p>
                            @endif
                        </div>

                        <div class="mt-4 flex justify-center">
                            <button class="mx-2 p-2 rounded-lg bg-blue-600 text-white">
                                <a href="{{ route('facture.show', $facture->id) }}"><i class="fas fa-search mr-2"></i>Détails</a>
                            </button>
                            <button class="mx-2">
                                <a href="{{ route('facture.edit', $facture->id) }}" class="p-2 rounded-lg bg-cyan-300"><i class="fas fa-edit mr-2"></i>Editer statut</a>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
