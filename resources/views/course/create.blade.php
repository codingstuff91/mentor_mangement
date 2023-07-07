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
                <select class="rounded-lg" name="student">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->nom }}</option>
                    @endforeach
                </select>

                <div class="my-2 flex flex-row justify-between items-center">
                    <div class="flex flex-col align-items-center">
                        <label class="my-2">Date du cours</label>
                        <input type="date" name="date_debut" class="rounded-lg">
                        @error('date_debut')
                            <div class="text-red-400">{{ $message }}</div>
                        @enderror
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
                        @error('heure_debut')
                            <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex flex-col align-items-center">
                        <label class="my-2">Heure fin</label>
                        <input type="time" name="heure_fin" class="rounded-lg">
                        @error('heure_fin')
                            <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <label class="my-2">Notions apprises</label>
                <textarea name="notions_apprises" class="rounded-lg" cols="30" rows="2"></textarea>
                @error('notions_apprises')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror

                <label class="my-2">Taux horaire</label>
                <input type="number" name="taux_horaire" class="rounded-lg">
                @error('taux_horaire')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror

                <label class="my-2">Facture concernée</label>
                <select class="rounded-lg" name="invoice">
                    @foreach ($invoices as $invoice)
                        <option value="{{ $invoice->id }}">{{ $invoice->month_year_creation }} -- {{ $invoice->customer->nom }}</option>
                    @endforeach
                </select>
                @error('invoice_id')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror

                <input type="submit" value="Confirmer" class="mt-4 rounded-lg p-2 bg-green-300">
            </form>
        </div>
    </div>
</x-app-layout>
