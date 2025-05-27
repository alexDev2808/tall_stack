@php
    $links = [
        [
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-house',
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'name' => 'Familias',
            'icon' => 'fa-solid fa-box-open',
            'route' => route('admin.families.index'),
            'active' => request()->routeIs('admin.families.*'),
        ],
        [
            'name' => 'Filiales',
            'icon' => 'fa-solid fa-globe',
            'route' => route('admin.subsidiaries.index'),
            'active' => request()->routeIs('admin.subsidiaries.*'),
        ],
        [
            'name' => 'Areas',
            'icon' => 'fa-solid fa-city',
            'route' => route('admin.areas.index'),
            'active' => request()->routeIs('admin.areas.*'),
        ],
        [
            'name' => 'Subareas',
            'icon' => 'fa-solid fa-network-wired',
            'route' => route('admin.subareas.index'),
            'active' => request()->routeIs('admin.subareas.*'),
        ],
        [
            'name' => 'Departamentos',
            'icon' => 'fa-solid fa-layer-group',
            'route' => route('admin.departaments.index'),
            'active' => request()->routeIs('admin.departaments.*'),
        ],
    ];
@endphp    
    
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-[100dvh] pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        :class="{
            'translate-x-0 ease-out': sidebarOpen,
            '-translate-x-full ease-in': !sidebarOpen
        }"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">

                @foreach($links as $link)
                    
                    <li>
                        <a href="{{ $link['route'] }}"
                            class="flex items-center p-2 text-gray-600 rounded-lg bg-gray-100 hover:bg-gray-300 dark:hover:bg-blue-800 group"
                            :class="{ '!bg-blue-600 hover:!bg-blue-600 text-white': {{ $link['active'] }} }"
                            >
                            <span class="inline-flex w-6 h-6 justify-center items-center">
                                <i 
                                    :class="{''}"
                                    class="{{ $link['icon'] }} "></i>
                            </span>
                            <span class="ms-2">{{ $link['name'] }}</span>
                        </a>
                    </li>


                @endforeach

            </ul>
        </div>
    </aside>
