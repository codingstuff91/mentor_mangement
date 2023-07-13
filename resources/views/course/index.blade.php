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
                    <button class="p-2 bg-blue-600 text-white text-lg rounded-lg">
                        <i class="fas fa-plus"></i>
                        <a href="{{ route('course.create') }}">Ajouter un cours</a>
                    </button>
                </div>
            </div>

            @foreach ($courses as $course)
            <div class="mt-2 w-full mx-auto sm:w-2/3 lg:w-1/2">
                <div class="p-2 bg-white border-b border-gray-200 overflow-hidden shadow-sm sm:rounded-lg flex justify-between">
                    <div class="flex flex-col">
                        <div class="text-base font-bold mb-2 p-2 bg-gray-200 rounded-lg">
                            <i class="fas fa-user mr-2"></i>{{ $course->student->name }}
                        </div>
                        <h1 class="text-sm font-extrabold">
                            <i class="fas fa-calendar-day mr-2"></i>{{ $course->date->format('d/m/Y') }}

                            <span class="px-2 text-xs rounded {{$course->paid ? "bg-green-200" : "bg-red-200"}}">
                                <i class="fas fa-dollar-sign"></i>
                                {{ $course->paid ? "Payé" : "Non payé" }}
                            </span>
                        </h1>
                        <p class="text-sm font-extrabold">
                            <i class="fas fa-clock my-2"></i> {{ $course->start_hour->format('H:i') }} -> {{ $course->end_hour->format('H:i') }} ({{ $course->hours_count }} heure{{ $course->hours_count > 1 ? "s" : "" }})
                        </p>
                        <p class="mt-2">{!! $course->learned_notions !!}</p>
                    </div>
                    <div class="flex flex-row h-1/2">
                        <button class="p-2 rounded-lg bg-blue-400 mr-2">
                            <a href="{{ route('course.edit', $course->id) }}"><i class="fas fa-edit"></i></a>
                        </button>
                        <form action="{{ route('course.destroy', $course->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="bg-red-400 p-2 rounded-lg" type="submit" onclick="return confirm('êtes-vous sur de vouloir le supprimer ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
