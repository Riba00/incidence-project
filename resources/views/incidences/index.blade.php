<x-app-layout>
    <x-slot name="header">
        <div class="sm:flex sm:items-center sm:justify-between">
            <h3 class="text-xl font-semibold text-gray-900">{{ __('Incidences') }}</h3>
            <div class="mt-3 sm:ml-4 sm:mt-0">
                <a href="{{ route('incidences.create') }}" wire:navigate
                    class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create New Incidence
                </a>
            </div>
        </div>
    </x-slot>



    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md mb-4 font-semibold">
                {{ session('message') }}
            </div>
            @endif
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <livewire:incidences-table />
                </div>
            </div>
        </div>
    </div>

</x-app-layout>