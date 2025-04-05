<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net" rel="preconnect">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

        @stack('css')

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <section class="bg-base-200 dark:bg-dark-base-200">
            <div class="mx-auto flex flex-col items-center justify-center px-6 py-8 md:min-h-screen lg:py-4">
                <div class="mb-4 flex items-center text-xl font-semibold text-gray-900 dark:text-white">
                    <a href="/">
                        <x-application-logo class="h-14 w-14 fill-current text-gray-500" />
                    </a>
                </div>

                <div class="dark:border-muted dark:bg-dark-base-100 bg-base-100 w-full rounded-lg shadow sm:max-w-md md:mt-0 xl:p-0 dark:border">
                    <div class="space-y-4 p-5 sm:p-8 md:space-y-6">

                        {{ $slot }}

                    </div>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        @stack('javascript')
    </body>

</html>
