<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des élèves') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-2 flex flex-row justify-center">
                    <button class="p-2 text-lg bg-blue-600 text-white rounded-lg">
                        <i class="fas fa-plus mr-2"></i>
                        <a href="{{ route('student.create') }}">Ajouter un élève</a>
                    </button>
                </div>
            </div>
            <div class="mt-4 w-full mx-auto p-2 bg-white border-b border-gray-200">
                @foreach ($students as $student)
                    <div class="my-4 flex flex-row justify-between items-center w-full mx-auto">
                        <div class="flex flex-col">
                            <h2 class="text-3xl flex items-center">{{ $student->nom }}</h2>
                            <div class="flex">
                                <p class="ml-2 p-2 text-xs rounded-lg bg-blue-100"><i class="fas fa-user mr-2"></i>{{ $student->client->nom }}</^p>
                                <p class="ml-2 p-2 text-xs rounded-lg bg-amber-300"><i class="fas fa-book mr-2"></i>{{ $student->matiere->nom }}</p>
                            </div>
                        </div>
                        <div class="buttons">
                            <button class="p-2 rounded-lg bg-blue-300 text-xs"><a href="{{ route('student.show', $student->id) }}"><i class="fas fa-search mr-2"></i></a></button>
                            <button class="p-2 rounded-lg bg-cyan-300 text-xs"><a href="{{ route('student.edit', $student->id) }}"><i class="fas fa-edit mr-2"></i></a></button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
