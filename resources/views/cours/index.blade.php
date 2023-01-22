<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des cours') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg flex justify-center">
                <div class="p-2">
                    <button class="p-2 bg-blue-300 rounded-lg">
                        <i class="fas fa-plus"></i>
                        <a href="{{ route('cours.create') }}">Nouveau cours</a>
                    </button>
                </div>
            </div>

            @foreach ($cours as $lecon)
            <div class="mt-2 w-3/4 mx-auto">
                <div class="p-2 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg flex justify-between">
                    <div class="flex flex-col">
                        <div class="text-xs mb-2 p-2 bg-green-200 rounded-lg">
                            <i class="fas fa-user mr-2"></i>{{ $lecon->eleve->nom }}
                        </div>
                        <h1 class="text-lg font-extrabold">
                            <i class="fas fa-calendar-day mr-2"></i>{{ $lecon->date_formated }}
                            @if ($lecon->paye)
                                <span class="p-2 text-xs rounded-lg bg-green-200">
                                    <i class="fas fa-dollar-sign"></i>
                                    OUI
                                </span>
                            @else
                                <span class="p-2 text-xs rounded-lg bg-red-200">
                                    <i class="fas fa-dollar-sign"></i>
                                    NON
                                </span>                                
                            @endif
                        </h1>
                        <p class="font-extrabold">
                            <i class="fas fa-clock my-2"></i> {{ $lecon->heure_debut }} -> {{ $lecon->heure_fin }} ({{ $lecon->nombre_heures }} heure{{ $lecon->nombre_heures > 1 ? "s" : "" }}) 
                        </p>
                        <p class="mt-2">{!! $lecon->notions_apprises !!}</p>
                    </div>
                    <div class="flex flex-row h-1/2">
                        <button class="text-xs p-2 rounded-lg bg-blue-300">
                            <i class="fas fa-edit mr-2"></i>
                            <a href="{{ route('cours.edit', $lecon->id) }}">Editer</a>
                        </button>
                        <form action="{{ route('cours.destroy', $lecon->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="ml-2 text-xs bg-red-400 text-white p-2 rounded-lg" type="submit"><i class="fas fa-trash mr-2"></i>Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>