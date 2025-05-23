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
        'name' => 'Editar',
    ],
]">

    <div x-data="{ show: true }" x-init="setTimeout(() => { show = false }, 3000)" x-show="show">
        <x-banner />
    </div>

    <div class="card">
        <form action="{{ route('admin.families.update', $family) }}" method="POST" novalidate>
            @csrf
            @method('PATCH')
            <div>
                <x-label class="mb-2">Nombre</x-label>
                <x-input name="name" type="text" value="{{ old('name', $family->name) }}"
                    placeholder="Nombre de la familia" :error="$errors->has('name')" />

                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <x-danger-button onclick="confirmDelete()">Eliminar</x-danger-button>
                <x-button>Actualizar</x-button>
            </div>
        </form>
    </div>

    <form id="delete-form" action="{{ route('admin.families.destroy', $family) }}" method="POST">
        @csrf
        @method('DELETE')

    </form>

    @push('js')
        <script>
            function confirmDelete() {

                Swal.fire({
                    title: "Confirmas la eliminacion?",
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
