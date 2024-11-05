<div class="mx-auto p-6 bg-white shadow-md rounded-md">
    
    <form wire:submit.prevent="submit">
        <!-- Contenedor de dos columnas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Campo de Título -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Title *</label>
                <input type="text" id="title" wire:model="title"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            @role('admin')
            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 font-medium mb-2">Assign To *</label>
                <select id="user_id" wire:model="user_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200">
                    <option value="">-- Select User --</option>
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
                    <option value="">-- Select Status --</option>
                    <option value="todo">To Do</option>
                    <option value="doing">Doing</option>
                    <option value="done">Done</option>
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

        </div>

        <!-- Campo de Descripción (ocupa todo el ancho) -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea id="description" wire:model="description"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-200"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <p class="text-sm text-gray-600">(*) Required Fields</p>
        <!-- Botones de Cancelar y Enviar -->
        <div class="flex items-center justify-end">
            <a href="{{ route('incidences.index') }}" wire:navigate
                class="inline-flex items-center px-3 py-2 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Cancel
            </a>
            <button type="submit" 
                class="ml-4 bg-indigo-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
                Create Incidence
            </button>
        </div>
    </form>
</div>