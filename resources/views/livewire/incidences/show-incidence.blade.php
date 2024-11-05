<x-slot name="header">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h3 class="text-xl font-semibold text-gray-900">{{ $incidence->title }}</h3>
        <div class="mt-3 sm:ml-4 sm:mt-0">
            <a href="{{ route('incidences.edit', ['id' => $incidence->id]) }}" wire:navigate
                class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Edit Incidence
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
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="px-4 py-6 sm:px-6">
                    <h3 class="text-base/7 font-semibold text-gray-900">Incidence Information</h3>
                </div>
                <div class="border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-900">Title</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $incidence->title }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-900">Status</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{
                                $incidence->getStatusLabelAttribute() }}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-900">Asigned To</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $incidence->user->name
                                }}</dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-900">Description</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{
                                $incidence->description }}</dd>
                        </div>

                        <div class="mt-5 px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <div class="flex items-center justify-start">
                                <a href="{{ route('incidences.index') }}" wire:navigate
                                    class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Back
                                </a>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>