<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-row">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl w-1/3">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-row justify-center items-center">
                        <img src="{{ asset('img/teaching.png') }}">
                        <h2 class="ml-4 text-xl font-bold">Heures de cours données</h2>
                    </div>
                    <h3 class="mt-4 text-3xl text-center">{{ $total_heures[0]->total }}</h3>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm rounded-xl w-1/3 ml-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-row justify-center items-center">
                        <img src="{{ asset('img/money.png') }}">
                        <h2 class="ml-4 text-xl font-bold">Heures de cours données</h2>
                    </div>
                    <h3 class="mt-4 text-3xl text-center">{{ $total_gains[0]->total }}€</h3>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
