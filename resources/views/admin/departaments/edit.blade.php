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
        'name' => 'Editar',
    ],
]">


    <x-banner />


    <div class="card">
        <form action="{{ route('admin.' . $routeController . '.update', $item) }}" method="POST" novalidate>
            @csrf
            @method('PATCH')
            <div>
                <x-label class="mb-2">Nombre</x-label>
                <x-input name="name" type="text" value="{{ old('name', $item->name) }}"
                    placeholder="Ingresa el nombre" :error="$errors->has('name')" />

                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-2">
                <x-label class="mb-2">Subarea</x-label>
                <select name="subarea_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('subarea_id') border-red-500 @enderror">
                    <option value="" disabled>Selecciona una subarea</option>
                    @foreach($related_items as $subarea)
                        <option value="{{ $subarea['id'] }}" 
                            {{ old('subarea_id', $item->subarea_id ?? '') == $subarea['id'] ? 'selected' : '' }}>
                            {{ $subarea['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('subarea_id')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-2 flex justify-end gap-2">
                <x-danger-button onclick="confirmDelete()">Eliminar</x-danger-button>
                <x-button>Actualizar</x-button>
            </div>
        </form>
    </div>

    <form id="delete-form" action="{{ route('admin.' . $routeController . '.destroy', $item) }}" method="POST">
        @csrf
        @method('DELETE')

    </form>

    @push('js')
        <script>
            function confirmDelete() {

                Swal.fire({
                    title: "¿Confirmas la eliminación?",
                    text: "No podras revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#2563eb",

                    confirmButtonText: "Si, eliminar!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form').submit();
                    }
                });
            }
        </script>
    @endpush

</x-admin-layout>
