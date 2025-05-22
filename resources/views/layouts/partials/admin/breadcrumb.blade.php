@if (count($breadcrumbs) > 0)
    <nav class="mb-4">
        <ol class="flex flex-wrap">
            @foreach ($breadcrumbs as $breadcrumb)
                <li 
                    :class="{'ps-2 before:float-left before:pe-2 before:content-[\'/\']' : {{ !$loop->first }} }"
                    class="text-sm leading-normal text-slate-700 ">

                    @isset($breadcrumb['route'])   
                        <a class="opacity-50" href="{{ $breadcrumb['route']}}">{{ $breadcrumb['name']}}</a>
                    @else
                        {{ $breadcrumb['name'] }}    
                    @endisset
                </li>
            @endforeach


            {{-- <li class="text-sm leading-normal text-slate-700 ps-2 before:float-left before:pe-2 before:content-['/']">
                <a class="opacity-50" href="">Productos</a>
            </li>
            <li class="text-sm leading-normal text-slate-700 ps-2 before:float-left before:pe-2 before:content-['/']">
                Nuevo
            </li> --}}
        </ol>

        @if (count($breadcrumbs) > 1)
            <h6 class="font-bold">
                {{ end($breadcrumbs)['name'] }}
            </h6>
                
        @endif
    </nav>
@endif
