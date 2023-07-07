<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajout nouvelle matière') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('subject.store') }}" method="post">
                        @csrf

                        <label>Nom de la matière</label>
                        <input type="text" name="nom" class="rounded-lg w-full"/>

                        @error('nom')
                            <div class="text-red-400">{{ $message }}</div>
                        @enderror

                        <input type="submit" class="bg-green-400 rounded p-2 mt-4 w-full" value="Confirmer"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
