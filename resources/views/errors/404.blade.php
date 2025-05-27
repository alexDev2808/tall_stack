<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        <title>{{ config('app.name', 'Admin') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font awesome -->
        <script src="https://kit.fontawesome.com/8ef6272e9d.js" crossorigin="anonymous"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>

    <body class="font-sans antialiased p-4">

        <div class="min-h-screen flex justify-center items-center border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">

            <section class="bg-white dark:bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                    <div class="mx-auto max-w-screen-sm text-center">
                        <h1 class="mb-4 text-7xl tracking-tight font-bold lg:text-9xl text-blue-600 dark:text-blue-500">404</h1>
                        <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white">Upss... Algo salió mal.</p>
                        <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">Lo sentimos, no podemos encontrar la página que buscas. Te recomendamos explorar la página de Inicio. </p>
                        <a href="#" onclick="window.history.back(); return false;" class="inline-flex text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-blue-900 my-4">Regresar</a>
                    </div>   
                </div>
            </section>

        </div>

    </body>

</html>


