<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Familias',
        'route' => route('admin.families.index'),
    ],
    [
        'name' => 'Crear',
    ]
]">

    <div class="card">
        <form action="{{ route('admin.families.store') }}" method="POST" novalidate>
            @csrf
            <div>
                <x-label class="mb-2">Nombre</x-label>
                <x-input 
                    name="name" 
                    type="text"
                    value="{{ old('name') }}"
                    placeholder="Nombre de la familia"
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