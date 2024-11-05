<x-app-layout>
    <x-slot name="header">
        <div class="sm:flex sm:items-center sm:justify-between">
            <h3 class="text-xl font-semibold text-gray-900">{{ __('Create New Incidnce') }}</h3>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:create-incidence-form />
            </div>
        </div>
    </div>

</x-app-layout>