<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des factures') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-2 flex flex-row justify-center">
                    <button class="p-2 bg-blue-600 rounded-lg text-white text-xl">
                        <i class="fas fa-plus mr-2"></i>
                        <a href="{{ route('invoice.create') }}">Ajouter une facture</a>
                    </button>
                </div>
            </div>
            <!-- main table component -->
            <div class="bg-gray-100 flex items-center justify-center font-sans overflow-auto">
                <div class="w-full lg:w-5/6">
                    <div class="bg-white shadow-md rounded my-2">
                        <table class="min-w-max w-full table-auto">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-center">Client</th>
                                <th class="py-3 px-6 text-center">Mois / année</th>
                                <th class="py-3 px-6 text-center">Total</th>
                                <th class="py-3 px-6 text-center">Statut</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($invoices as $invoice)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-center whitespace-nowrap">
                                            <span class="bg-blue-100 text-blue-600 py-1 px-3 rounded-lg text-lg">
                                                <i class="fas fa-user mr-2"></i>
                                                {{ $invoice->customer->name }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center whitespace-nowrap">
                                            <span class="bg-yellow-100 text-yellow-600 py-1 px-3 rounded-lg text-lg">
                                                <i class="fas fa-calendar mr-2"></i>
                                            {{ $invoice->created_at->format('M-Y') }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center whitespace-nowrap">
                                            <span class="py-1 px-3 rounded-lg text-lg">
                                            {{ $invoice->courses_sum_price ?? 0}} €
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center whitespace-nowrap">
                                            <span class="text-sm p-2 rounded-lg font-bold {{ $invoice->paid ? "bg-green-200" : "bg-red-200" }}">
                                                <i class="fas fa-dollar-sign"></i>
                                                {{ $invoice->paid ? "Payée" : "Non payée" }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex items-center justify-center">
                                                <div class="w-6 mr-2 transform text-blue-500 hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('invoice.show', $invoice) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div class="w-6 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <a href="{{ route('invoice.edit', $invoice) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div class="w-6 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                    <form
                                                        action="{{ route('invoice.destroy', $invoice->id) }}"
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
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
