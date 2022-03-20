<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="my-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl w-1/2">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-row justify-center items-center">
                        <img src="{{ asset('img/teaching.png') }}">
                        <h2 class="ml-4 text-xl font-bold">Heures de cours données</h2>
                    </div>
                    <h3 class="mt-4 text-3xl text-center">{{ $total_heures[0]->total }}</h3>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm rounded-xl w-1/2 ml-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-row justify-center items-center">
                        <img src="{{ asset('img/money.png') }}">
                        <h2 class="ml-4 text-xl font-bold">Total des revenus</h2>
                    </div>
                    <h3 class="mt-4 text-3xl text-center">{{ $total_gains[0]->total }}€</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl w-full">
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
                                    <td class="p-2 bg-blue-200 text-center">{{ $nombre_heures_par_eleve[$i]->total }} heures</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
</x-app-layout>
