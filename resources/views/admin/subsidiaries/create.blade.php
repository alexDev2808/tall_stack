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

            <div class="flex justify-end">
                <x-button>Guardar</x-button>
            </div>
        </form>
    </div>

</x-admin-layout>