<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des matières') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 flex flex-row justify-center">
                    <button class="p-2 bg-blue-600 text-white text-lg rounded-lg">
                        <i class="fas fa-plus mr-2"></i>
                        <a href="{{ route('subject.create') }}">Ajouter une matière</a>
                    </button>
                </div>
            </div>
            <div>
                @foreach ($subjects as $subject)
                    <div class=" w-full mx-auto mt-2 p-4 bg-white flex justify-between items-center sm:w-2/3 lg:w-1/2">
                        <p class="font-bold text-lg">{{ $subject->name }}</p>
                        <div class="flex flex-row">
                            <button class="p-2 rounded-lg bg-blue-300"><a href="{{ route('subject.edit',$subject->id) }}"><i class="fas fa-edit"></i></a></button>
                            <form action="{{ route('subject.destroy', $subject->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="ml-2 bg-red-400 p-2 rounded-lg" type="submit" onclick="confirm('etes vous sur de vouloir supprimer ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
