<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script>
            (function() {
                if (localStorage.getItem("theme") === "dark") {
                    document.documentElement.classList.add("dark");
                }
            })();
        </script>
        <title>@yield('title') • Dashboard | {{ config('app.name') }}</title>

        <meta content="@yield('meta_description', '') name="description">
        <meta name="author" content="@yield('meta_author', 'Ahmad Zaki Alawi')">

        <meta property="og:title" content="@yield('og_title', config('app.name'))" />
        <meta property="og:type" content="@yield('og_type', 'website')" />
        <meta property="og:url" content="@yield('og_url', url()->current())" />
        <meta property="og:description" content="@yield('og_description', config('app.name'))" />
        <meta property="og:image" content="@yield('og_image', asset('assets/img/favicon.png'))" />

        <meta name="robots" content="@yield('meta_robots', 'noindex, nofollow')">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.bunny.net" rel="preconnect">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

        @stack('css')
        {{ $css ?? '' }}

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app-dashboard.js', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        <div class="sticky inset-x-0 top-0 z-20">
            <!-- ========== HEADER ========== -->
            <x-dashboard.app-header />
            <!-- ========== END HEADER ========== -->

            <!-- Breadcrumb Section -->
            <div class="relative -mt-px">
                <div class="dark:bg-dark-base-200 dark:border-dark-base-300 z-20 border-y border-gray-200 bg-white px-4 sm:px-6 lg:hidden lg:px-8">
                    <div class="flex items-center py-2">
                        <!-- Navigation Toggle -->
                        <button class="focus:outline-hidden flex size-8 items-center justify-center gap-x-2 rounded-lg border border-gray-200 text-gray-800 hover:text-gray-500 focus:text-gray-500 disabled:pointer-events-none disabled:opacity-50 dark:border-neutral-700 dark:text-neutral-200 dark:hover:text-neutral-500 dark:focus:text-neutral-500" data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" aria-expanded="false">
                            <span class="sr-only">Toggle Navigation</span>
                            <i class="ri-sidebar-unfold-line text-xl"></i>
                        </button>
                        <!-- End Navigation Toggle -->

                        <!-- Breadcrumb -->
                        <x-dashboard.breadcrumb :items="generate_breadcrumbs()" />

                        <!-- End Breadcrumb -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumb Section -->

        <!-- Sidebar -->
        <x-dashboard.app-sidebar />
        <!-- End Sidebar -->

        <!-- ========== MAIN CONTENT ========== -->
        <!-- Content -->
        <main class="bg-base-200 dark:bg-dark-base-200/85 dark:text-light min-h-screen w-full text-gray-900 lg:ps-64">
            <div class="space-y-1 p-3 sm:p-0">
                <!-- your content goes here ... -->

                {{ $slot }}

            </div>
        </main>
        <!-- End Content -->
        <!-- ========== END MAIN CONTENT ========== -->

        <!-- Supporting Components -->
        <x-dashboard.toast />
        <x-dashboard.alert-modal />

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        @stack('javascript')
        {{ $javascript ?? '' }}
    </body>

</html>
