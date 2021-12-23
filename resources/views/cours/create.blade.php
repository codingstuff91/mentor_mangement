<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajout de nouveau cours') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 mx-auto w-1/2">
                    <form class="flex flex-col" action="{{ route('cours.store') }}" method="post">
                            @csrf
                            <label class="my-2">Eleve</label>
                            <select name="eleve_id">
                                @foreach ($eleves as $eleve)
                                    <option value="{{ $eleve->id }}">{{ $eleve->nom }}</option>
                                @endforeach
                            </select>

                            <label class="my-2">Date début</label>
                            <input type="date" name="date_debut" class="rounded-lg">

                            <label class="my-2">Heure début</label>
                            <input type="time" name="heure_debut" class="rounded-lg">

                            <label class="my-2">Heure fin</label>
                            <input type="time" name="heure_fin" class="rounded-lg">
                            
                            <label class="my-2">Notions apprises</label>
                            <textarea name="notions" class="rounded-lg" cols="30" rows="2"></textarea>

                            <label class="my-2">Taux horaire</label>
                            <input type="number" name="taux_horaire" class="rounded-lg">

                            <label class="my-2">Facture concernée</label>
                            <select name="facture_id">
                                @foreach ($factures as $facture)
                                    <option value="{{ $facture->id }}">{{ $facture->id }} -- {{ $facture->client->nom }}</option>
                                @endforeach
                            </select>

                            <input type="submit" value="Confirmer" class="mt-4 rounded-lg p-2 bg-green-400">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
