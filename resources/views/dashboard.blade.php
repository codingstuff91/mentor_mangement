<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="my-6 pt-4">
        <div class="px-2 mx-auto columns-2 gap-4 lg:columns-4 lg:gap-4 lg:max-w-7xl lg:px-8">
            <div class="bg-white shadow-lg rounded-xl mb-4">
                <div class="p-4 bg-white rounded-lg">
                    <div class="flex space-between h-20">
                        <div>
                            <img class="h-full" src="{{ asset('img/time.png') }}">
                        </div>
                        <div class="p-2 flex flex-col content-center items-center">
                            <h2 class="text-sm sm:text-xl">Total Heures</h2>
                            <h3 class="text-sm mt-2 font-bold sm:text-xl">{{ $totalCoursesHours[0]->total }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-xl mb-4">
                <div class="p-4 bg-white rounded-lg">
                    <div class="flex space-between h-20">
                        <div>
                            <img class="h-full" src="{{ asset('img/lesson.png') }}">
                        </div>
                        <div class="p-2 flex flex-col content-center items-center">
                            <h2 class="text-sm sm:text-xl">Total Cours</h2>
                            <h3 class="text-sm mt-2 font-bold sm:text-xl">{{ $totalCourses }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-xl mb-4">
                <div class="p-4 bg-white rounded-lg">
                    <div class="flex space-between h-20">
                        <div>
                            <img class="h-full" src="{{ asset('img/money.png') }}">
                        </div>
                        <div class="p-2 flex flex-col content-center items-center">
                            <h2 class="text-sm sm:text-xl">Total revenus</h2>
                            <h3 class="text-sm mt-2 font-bold sm:text-xl">{{ $totalRevenues[0]->total }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-xl mb-4">
                <div class="p-4 bg-white rounded-lg">
                    <div class="flex space-between h-20">
                        <div>
                            <img class="h-full" src="{{ asset('img/student.png') }}">
                        </div>
                        <div class="p-2 flex flex-col content-center items-center">
                            <h2 class="text-sm sm:text-xl">Total Eleves</h2>
                            <h3 class="text-sm mt-2 font-bold sm:text-xl">{{ $totalStudents }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="max-w-7xl mx-auto flex flex-row sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl w-full">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl text-bold text-center sm:text-xl lg:text-3xl">Heures de cours par matières</h2>
                    <table class="rounded-l-lg w-full border-collapse mx-auto table-auto sm:w-2/3 lg:w-1/3 mt-4">
                        <thead>
                            <tr>
                                <th class="border-2 border-gray-600 text-sm bg-blue-500 text-white p-2 text-center sm:text-xl">MATIERE</th>
                                <th class="border-2 border-gray-600 text-sm bg-blue-500 text-white p-2 text-center sm:text-xl">NOMBRE HEURES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < $totalHoursPerSubject->count(); $i++)
                                <tr>
                                    <td class="border-2 border-gray-600 p-2 bg-blue-200 text-center sm:text-x">{{ $totalHoursPerSubject[$i]->nom }}</td>
                                    <td class="border-2 border-gray-600 p-2 bg-blue-200 text-center sm:text-x">{{ $totalHoursPerSubject[$i]->total }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
