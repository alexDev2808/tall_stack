<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => $pluralNameController,
        'route' => route('admin.' . $routeController . '.index'),
    ],
    [
        'name' => 'Crear',
    ]
]">

    <div class="card">
        <form action="{{ route('admin.' . $routeController . '.store') }}" method="POST" novalidate>
            @csrf
            <div>
                <x-label class="mb-2">Nombre</x-label>
                <x-input 
                    name="name" 
                    type="text"
                    value="{{ old('name') }}"
                    placeholder="Ingresa el nombre"
                    :error="$errors->has('name')" />

                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-label class="mb-2">Filial</x-label>
                <select name="subsidiary_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('subsidiary_id') border-red-500 @enderror">
                    <option value="" disabled selected>Selecciona una filial</option>
                    @foreach($related_items as $item)
                        <option value="{{ $item['id'] }}" {{ old('subsidiary_id') == $item['id'] ? 'selected' : '' }}>{{ $item['name'] }}</option>
                    @endforeach
                </select>
                @error('subsidiary_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-2 flex justify-end">
                <x-button>Guardar</x-button>
            </div>
        </form>
    </div>

</x-admin-layout>