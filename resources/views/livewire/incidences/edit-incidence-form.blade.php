<x-slot name="header">
    <div class="sm:flex sm:items-center sm:justify-between">
        <h3 class="text-xl font-semibold text-gray-900">{{ $incidence->title }} - EDIT</h3>
    </div>
</x-slot>

<div class="py-12">
    <div class="mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="mx-auto p-6 bg-white shadow-md rounded-md">

                <form wire:submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                        @role('admin')
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 font-medium mb-2">Title *</label>
                            <input type="text" id="title" wire:model="title"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @endrole


                        @role('admin')
                        <div class="mb-4">
                            <label for="user_id" class="block text-gray-700 font-medium mb-2">Assign To *</label>
                            <select id="user_id" wire:model="user_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @endrole

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 font-medium mb-2">Status *</label>
                            <select id="status" wire:model="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                                <option value="todo">To Do</option>
                                <option value="doing">Doing</option>
                                <option value="done">Done</option>
                            </select>
                            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    @role('admin')
                    <div class="mb-2">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea id="description" wire:model="description"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    @endrole

                    <p class="text-sm text-gray-600 mb-4">(*) Required Fields</p>
                    <div class="flex items-center justify-between">
                        <div>
                            @role('admin')
                            <a href="{{ route('incidences.delete', ['id'=> $incidence->id]) }}" wire:navigate
                                class="inline-flex items-center bg-red-600 text-white px-3 py-2 text-sm font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Delete
                            </a>
                            @endrole
                        </div>
                        <div>
                            <a href="{{ route('incidences.show', ['id'=> $incidence->id]) }}" wire:navigate
                                class="inline-flex items-center px-3 py-2 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="ml-4 bg-indigo-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>