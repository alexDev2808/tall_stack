<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Familias',
    ],
]">

    <x-banner />

    <x-slot name="action">
        <a href="{{ route('admin.families.create') }}" class="btn btn-blue">
            Nuevo
        </a>
    </x-slot>

    @if (count($families) == 0)

        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
            role="alert">
            <span class="font-medium"></span> No hay registros de familias.
        </div>
    @else
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($families as $family)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $family->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $family->name }}
                            </td>
                            <td class="flex justify-end gap-2 py-4">
                                <a class="btn btn-yellow" href="{{ route('admin.families.edit', $family) }}">Editar</a>
                                <form id="delete-form-{{ $family->id }}" action="{{ route('admin.families.destroy', $family) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="current_page" value="index">
                                    <x-danger-button onclick="confirmDelete({{ $family->id }})">Eliminar</x-danger-button>
                                </form>
                                        
                            </td>

                        </tr>

                        
                    @endforeach
                </tbody>
            </table>
        </div>

        

        <div class="mt-4">
            {{ $families->links() }}
        </div>
    @endif

    @push('js')
        <script>
            function confirmDelete(id) {

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
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>
    @endpush

</x-admin-layout>
