<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="my-6 pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row justify-center columns-4 gap-4 sm:columns-2 gap-2">
            <div class="bg-white shadow-lg rounded-xl">
                <div class="p-4 bg-white rounded-lg">
                    <div class="flex space-between">
                        <div class="h-auto w-32">
                            <img src="{{ asset('img/time.png') }}">
                        </div>
                        <div class="p-2 flex flex-col content-center">
                            <h2 class="text-xl">Total Heures</h2>
                            <h3 class="mt-2 text-2xl font-bold">{{ $total_heures[0]->total }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-xl">
                <div class="p-4 bg-white rounded-lg">
                    <div class="flex space-between">
                        <div class="h-auto w-32">
                            <img src="{{ asset('img/lesson.png') }}">
                        </div>
                        <div class="p-2 flex flex-col content-center">
                            <h2 class="text-xl">Total Cours</h2>
                            <h3 class="mt-2 text-2xl font-bold">{{ $total_heures[0]->total }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-xl">
                <div class="p-4 bg-white rounded-lg">
                    <div class="flex space-between">
                        <div class="h-auto w-32">
                            <img src="{{ asset('img/money.png') }}">
                        </div>
                        <div class="p-2 flex flex-col content-center">
                            <h2 class="text-xl">Total revenus</h2>
                            <h3 class="mt-2 text-2xl font-bold">{{ $total_gains[0]->total }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-lg rounded-xl">
                <div class="p-4 bg-white rounded-lg">
                    <div class="flex space-between">
                        <div class="h-auto w-32">
                            <img src="{{ asset('img/student.png') }}">
                        </div>
                        <div class="p-2 flex flex-col content-center">
                            <h2 class="text-xl">Total Eleves</h2>
                            <h3 class="mt-2 text-2xl font-bold">{{ $total_eleves }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl w-full">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-3xl text-bold text-center">Heures de cours par matières</h2>
                    <table class="border-collapse mx-auto table-auto lg:w-1/3 sm:w-full mt-4">
                        <thead>
                            <tr>
                                <th class="bg-blue-400 p-2 text-center">MATIERE</th>
                                <th class="bg-blue-400 p-2 text-center">NOMBRE HEURES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < $nombre_heures_par_eleve->count(); $i++)
                                <tr>
                                    <td class="p-2 bg-blue-200 text-center">{{ $nombre_heures_par_eleve[$i]->nom }}</td>
                                    <td class="p-2 bg-blue-200 text-center">{{ $nombre_heures_par_eleve[$i]->total }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
</x-app-layout>
