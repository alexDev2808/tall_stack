@php
    $links = [
        [
            'icon' => 'fa-solid fa-house',
            'name' => 'Dashboard',
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ]

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
                            class="flex items-center p-2 text-white rounded-lg hover:bg-blue-800 dark:hover:bg-blue-800 group"
                            :class="{ 'bg-blue-700': {{ $link['active'] }} }"
                            >
                            <span class="inline-flex w-6 h-6 justify-center items-center">
                                <i class="{{ $link['icon'] }} text-white "></i>
                            </span>
                            <span class="ms-2">{{ $link['name'] }}</span>
                        </a>
                    </li>


                @endforeach

            </ul>
        </div>
    </aside>
