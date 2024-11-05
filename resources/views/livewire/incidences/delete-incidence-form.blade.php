<x-slot name="header">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h3 class="text-xl font-semibold text-gray-900">{{ $incidence->title }} - DELETE</h3>
    </div>
</x-slot>

<div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white shadow-md rounded-md">

                <form wire:submit.prevent="submit">
                    <div class="mb-6">
                        <label for="title" class="block text-gray-700 font-medium mb-2">
                            Are you sure you want to delete this incidence? Enter "<strong>{{ $incidence->title }}</strong>" to confirm.
                        </label>
                        <input type="text" id="title" wire:model="confirmationText" placeholder="{{ $incidence->title }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                        @error('confirmationText') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('incidences.show', ['id' => $incidence->id]) }}" 
                            class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="ml-4 px-4 py-2 font-semibold text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
