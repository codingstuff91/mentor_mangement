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
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>

                <div class="my-2 flex flex-row justify-between items-center">
                    <div class="flex flex-col align-items-center">
                        <label class="my-2">Date du cours</label>
                        <input type="date" name="course_date" class="rounded-lg" value="{{ $currentDay }}">
                        @error('date')
                            <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex flex-col justify-center">
                        <label>Pack d'heures</label>
                        <input type="checkbox" class="rounded-lg" name="hours_pack">
                    </div>
                </div>

                <div class="my-2 columns-2 gap-4">
                    <div class="flex flex-col align-items-center">
                        <label class="my-2">Heure début</label>
                        <input type="time" name="start_hour" class="rounded-lg">
                        @error('start_hour')
                            <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex flex-col align-items-center">
                        <label class="my-2">Nombre heures</label>
                        <input type="time" name="duration" class="rounded-lg" value="01:00">

                        @error('duration')
                            <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <label class="my-2">Notions apprises</label>
                <textarea name="learned_notions" class="rounded-lg" cols="30" rows="2"></textarea>
                @error('learned_notions')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror

                <label class="my-2">Taux horaire</label>
                <input type="number" name="hourly_rate" class="rounded-lg">
                @error('hourly_rate')
                    <div class="text-red-400">{{ $message }}</div>
                @enderror

                <label class="my-2">Facture concernée</label>
                <select class="rounded-lg" name="invoice">
                    @foreach ($invoices as $invoice)
                        <option value="{{ $invoice->id }}">{{ $invoice->month_year_creation }} -- {{ $invoice->customer->name }}</option>
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
