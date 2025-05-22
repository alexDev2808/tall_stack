<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Familias',
    ],
]">

    <div x-data="{ show: true }" x-init="setTimeout(() => { show = false }, 4000)" x-show="show">
        <x-banner />
    </div>

    <x-slot name="action">
        <a href="{{ route('admin.families.create')}}" class="btn btn-blue">
            Nuevo
        </a>
    </x-slot>

    @if (count($families) == 0)

        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
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
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $family->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $family->name }}
                            </td>
                            <td class="flex justify-end gap-2 py-4">
                                <a class="btn btn-yellow" href="{{ route('admin.families.edit', $family)}}">Editar</a>
                                {{-- <a class="btn btn-red" href="{{ route('admin.families.destroy', $family)}}">Eliminar</a> --}}
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


</x-admin-layout>
