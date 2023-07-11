<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajout nouvel eleve') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('student.store') }}" method="post">
                        @csrf
                        <div class="mb-4 mx-auto w-full columns-3">
                            <label>Nom</label>
                            <input type="text" name="nom" class="rounded-lg w-full"/>

                            <label>Matière</label>
                            <select name="subject" class="rounded-lg w-full">
                                <option value="">-- Choisir une matère --</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{$subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>

                            <label>customer</label>
                            <select name="customer" class="rounded-lg w-full">
                                <option value="">-- Choisir un client --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full my-4">
                            <label>Objectifs</label>
                            <textarea class="block rounded-lg w-full" name="objectifs" cols="4" rows="2"></textarea>
                        </div>
                        <div class="w-full my-4">
                            <label class="block">Commentaires</label>
                            <textarea class="block rounded-lg w-full" name="commentaires" cols="4" rows="2"></textarea>
                        </div>

                        <input type="submit" class="bg-green-400 rounded p-2 mt-4 w-full" value="Confirmer"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
