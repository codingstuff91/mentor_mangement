<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des Clients') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-gray-200 flex flex-row justify-center">
                    <button class="p-2 bg-blue-600 text-white text-lg rounded-lg">
                        <i class="fas fa-plus mr-2"></i>
                        <a href="{{ route('customer.create') }}">Ajouter un client</a>
                    </button>
                </div>
                <div class="p-4 bg-white border-b border-gray-200">
                    @foreach ($customers as $customer)
                        <div class="flex justify-between my-4 w-full mx-auto sm:w-2/3">
                            <div class="px-2">
                                <h2 class="text-xl font-bold">{{ $customer->name }}</h2>
                                <p>{!! $customer->comments !!}</p>
                            </div>
                            <div class="flex flex-row items-center">
                                <button class="p-2 bg-blue-300 rounded-lg mr-2"><a href="{{ route('customer.edit', $customer->id) }}"><i class="fas fa-edit"></i></a></button>
                                <form action="{{ route('customer.destroy', $customer->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="bg-red-400 p-2 rounded-lg" type="submit"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
