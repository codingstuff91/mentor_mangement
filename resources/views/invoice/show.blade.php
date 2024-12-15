<x-app-layout>
    <x-slot name="header">
        <h2 class="p-2 font-semibold text-xl text-gray-800 text-center">
            <i class="fas fa-user mr-2"></i>
            {{ $invoice->customer->name }}
            <i class="fas fa-calendar-day mx-2"></i>
            {{ $invoice->created_at->format('M-Y') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <h2 class="my-4 text-xl font-bold text-center">
            Nombre heures : {{ $total_hours }}
        </h2>
        <h2 class="p-2 rounded-lg bg-green-200 text-2xl text-center font-bold w-24 mx-auto">
            {{ $total_invoice }} €
        </h2>

        @foreach ($invoice->courses as $course)
            <div class="bg-white w-full my-4 p-4 mx-auto sm:w-[450px]">
                <div class="mb-2 p-2 bg-gray-200 rounded-lg flex justify-between">
                    <p class="text-lg font-bold">
                        <i class="fas fa-user mr-2"></i>
                        {{ $course->student->name }} -- {{ $course->hours_count }}h
                    </p>
                    <p class="font-bold mr-2">{{ $course->price }} €</p>
                </div>

                <p>
                    <i class="fas fa-calendar-day mr-2"></i>
                    le {{ $course->date->format('d/m/Y') }}
                </p>
                <p>
                    <i class="fas fa-clock mr-2"></i>
                    {{ $course->start_hour->format('H:i') }} --> {{ $course->end_hour->format('H:i') }}
                </p>
            </div>
        @endforeach
    </div>
</x-app-layout>
