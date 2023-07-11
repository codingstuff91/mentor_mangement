<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edition de matière') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <form action="{{ route('subject.update', $subject->id) }}" method="post" class="w-full">
                        @csrf
                        @method('patch')

                        <div class="mt-4 mx-auto">
                            <label>Nom de la matière</label>
                            <input type="text" name="name" class="rounded-lg w-full" value="{{ $subject->name }}"/>
                        </div>

                        <button class="bg-green-400 rounded-lg p-2 mt-4 w-full">Confirmer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
