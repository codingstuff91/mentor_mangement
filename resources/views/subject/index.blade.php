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
                    <button class="p-2 text-lg bg-green-200 text-green-600 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>
                        <a href="{{ route('subject.create') }}">Ajouter une matière</a>
                    </button>
                </div>
            </div>
            <!-- main table component -->
            <div class="bg-gray-100 flex items-center justify-center bg-gray-100 font-sans overflow-auto">
                <div class="w-full lg:w-5/6">
                    <div class="bg-white shadow-md rounded my-2">
                        <table class="min-w-max w-full table-auto">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-center">Nom</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($subjects as $subject)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-center whitespace-nowrap">
                                            <span class="py-1 px-3 rounded-lg text-lg">
                                                {{ $subject->name }}
                                            </span>
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center">
                                            <div class="w-6 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <a href="{{ route('subject.edit', $subject) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="w-6 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                <form
                                                    action="{{ route('subject.destroy', $subject->id) }}"
                                                    method="post"
                                                    onclick="return confirm('êtes-vous sur de vouloir la supprimer ?')"
                                                >
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit">
                                                        <i class="fas fa-trash text-lg text-red-500"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
