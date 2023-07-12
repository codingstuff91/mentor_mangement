<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ $student->name }}
        </h2>
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ $student->subject->name }}
        </h2>
    </x-slot>

    <div class="py-4">
        <h2 class="text-2xl font-bold text-center mb-2">Objectifs</h2>
        <div class="w-full p-4 bg-white border-b border-gray-400 mb-4">
            <p class="my-2 text-center text-lg">{!! $student->goals !!}</p>
        </div>

        <h2 class="text-2xl font-bold text-center mt-4 mb-2">{{ $student->cours_count }} Cours réalisés</h2>
        @foreach ($student->courses as $course)
            <div class="p-2 bg-white shadow-sm border-b border-gray-400 w-full my-4 mx-auto sm:w-3/4">
                <div class="my-2 flex flex-col justify-between">
                    <p><i class="fas fa-calendar-day mr-2"></i>{{ $course->date->format('d/m/Y') }}</p>
                    <p><i class="fas fa-clock"></i> {{ $course->start_hour->format('H:i') }} --> {{ $course->end_hour->format('H:i') }} ({{ $course->hours_count }}heure{{ $course->hours_count > 1 ? "s" : ""}})</p>
                </div>
                <div class="flex flex-col w-full">
                    <h2 class="text-xl font-bold">Notions travaillées : </h2>
                    <p class="text-lg">{!! $course->learned_notions !!}</p>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
