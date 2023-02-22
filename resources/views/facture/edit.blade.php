<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mise à jour statut facture') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" mx-auto p-4 bg-white border-b border-gray-200">
                    <form action="{{ route('facture.update', $facture->id) }}" method="post" class="flex flex-col">
                        @csrf
                        @method('patch')

                        <label class="mt-2">Facture payée</label>
                        <select class="mt-2 rounded-lg" name="payee" class="rounded-lg">
                            <option value="0" @if ($facture->payee == 0) selected="selected" @endif>NON</option>
                            <option value="1" @if ($facture->payee == 1) selected="selected" @endif>OUI</option>
                        </select>

                        <input type="submit" value="Confirmer" class="p-2 mt-4 rounded-lg bg-green-400">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
