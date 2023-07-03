<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un cours') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mt-4 p-4 bg-white mx-auto sm:w-3/4 sm:p-6">
            <form class="flex flex-col" action="{{ route('course.store') }}" method="post">
                @csrf
                <label class="my-2">Eleve</label>
                <select class="rounded-lg" name="eleve_id">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->nom }}</option>
                    @endforeach
                </select>

                <div class="my-2 flex flex-row justify-between items-center">
                    <div class="flex flex-col align-items-center">
                        <label class="my-2">Date du cours</label>
                        <input type="date" name="date_debut" class="rounded-lg">
                    </div>
                    <div class="flex flex-col justify-center">
                        <label>Pack d'heures</label>
                        <input type="checkbox" class="rounded-lg" name="pack_heures">
                    </div>
                </div>

                <div class="my-2 columns-2 gap-4">
                    <div class="flex flex-col align-items-center">
                        <label class="my-2">Heure début</label>
                        <input type="time" name="heure_debut" class="rounded-lg">
                    </div>

                    <div class="flex flex-col align-items-center">
                        <label class="my-2">Heure fin</label>
                        <input type="time" name="heure_fin" class="rounded-lg">
                    </div>


                </div>

                <label class="my-2">Notions apprises</label>
                <textarea name="notions" class="rounded-lg" cols="30" rows="2"></textarea>

                <label class="my-2">Taux horaire</label>
                <input type="number" name="taux_horaire" class="rounded-lg">

                <label class="my-2">Facture concernée</label>
                <select class="rounded-lg" name="facture_id">
                    @foreach ($factures as $facture)
                        <option value="{{ $facture->id }}">{{ $facture->month_year_creation }} -- {{ $facture->customer->nom }}</option>
                    @endforeach
                </select>

                <input type="submit" value="Confirmer" class="mt-4 rounded-lg p-2 bg-green-300">
            </form>
        </div>
    </div>
</x-app-layout>
