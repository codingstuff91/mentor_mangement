<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editer un eleve') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="w-full mx-auto sm:px-6 sm:w-3/4 lg:w-2/3 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg drop-shadow-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('student.update', $student->id) }}" method="post" class="flex flex-col">
                        @csrf
                        @method('patch')

                        <label>Nom de l'élève</label>
                        <input type="text" name="nom" value="{{ $student->name }}" class="rounded-lg mt-2">

                        <label class="mt-2">Statut élève</label>
                        <select class="mt-2 rounded-lg" name="active" class="rounded-lg" value="{{ $student->active }}">
                            <option value="0" @if ($student->active == 0) selected="selected" @endif>INACTIF/VE</option>
                            <option value="1" @if ($student->active == 1) selected="selected" @endif>ACTIF/VE</option>
                        </select>

                        <label class="mt-2">Matiere concernée</label>
                        <select class="mt-2 rounded-lg" name="subject_id" class="rounded-lg">
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id}}" @if ($subject->id == $student->subject_id) selected="selected" @endif>{{ $subject->name }}</option>
                            @endforeach
                        </select>

                        <label class="mt-2">Client concerné</label>
                        <select class="mt-2 mb-4 rounded-lg" name="client_id" class="rounded-lg">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id}}" @if ($customer->id == $student->customer_id) selected="selected" @endif>{{ $customer->name }}</option>
                            @endforeach
                        </select>

                        <label for="">Objectifs</label>
                        <textarea name="objectifs" cols="30" rows="10">{!! $student->goals !!}</textarea>

                        <input type="submit" value="Confirmer" class="p-2 mt-4 rounded-lg bg-green-400">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
