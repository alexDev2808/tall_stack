@props(['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')])

<div 
    x-data="{ show: false, style: '{{ $style }}', message: '{{ $message }}' }"
    x-init="
        if (message) { 
            setTimeout(() => { 
                show = true 
                setTimeout(() => { show = false }, 3000) 
            }, 50);
        }
    "
    class="rounded-lg mb-2 border fixed top-6 right-6 z-50 w-4/5 sm:w:full max-w-md shadow-lg"
    :class="{ 'bg-green-100 text-green-800 border-green-500': style == 'success', 'bg-red-100 text-red-800': style == 'danger', 'bg-yellow-100 text-yellow-700': style == 'warning', 'bg-gray-500': style != 'success' && style != 'danger' && style != 'warning'}"
    x-show="show && message"
    x-transition:enter="transition transform duration-500"
    x-transition:enter-start="opacity-0 translate-x-full"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition transform duration-500"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-full"
    x-on:banner-message.window="
        style = event.detail.style;
        message = event.detail.message;
        show = true;
        setTimeout(() => { 
            show = true 
            setTimeout(() => { show = false }, 3000) 
        }, 50);
    "
>
    <div class="py-2 px-3 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between flex-wrap">
            <div class="w-0 flex-1 flex items-center min-w-0">
                <span class="flex p-2 rounded-lg" :class="{ 'bg-green-600': style == 'success', 'bg-red-600': style == 'danger', 'bg-yellow-600': style == 'warning' }">
                    <svg x-show="style == 'success'" class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <svg x-show="style == 'danger'" class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <svg x-show="style != 'success' && style != 'danger' && style != 'warning'" class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <svg x-show="style == 'warning'" class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" fill="none" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4v.01 0 0 " />
                    </svg>
                </span>

                <p class="ms-3 font-medium text-sm truncate" x-text="message"></p>
            </div>

            <div class="shrink-0 sm:ms-3">
                <button
                    type="button"
                    class="-me-1 flex p-2 rounded-md focus:outline-none sm:-me-2 transition"
                    :class="{ 'bg-green-600 hover:bg-green-800 focus:bg-green-800': style == 'success', 'bg-red-600 hover:bg-red-800 focus:bg-red-800': style == 'danger', 'bg-yellow-600 hover:bg-yellow-800 focus:bg-yellow-800': style == 'warning'}"
                    aria-label="Dismiss"
                    x-on:click="show = false">
                    <svg class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
