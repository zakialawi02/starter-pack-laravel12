<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>@yield('title', config('app.name'))</title>
        <meta content="@yield('meta_description', '') name="description">
        <meta name="author" content="@yield('meta_author', 'Ahmad Zaki Alawi')">

        <meta property="og:title" content="@yield('og_title', config('app.name'))" />
        <meta property="og:type" content="@yield('og_type', 'website')" />
        <meta property="og:url" content="@yield('og_url', url()->current())" />
        <meta property="og:description" content="@yield('og_description', config('app.name'))" />
        <meta property="og:image" content="@yield('og_image', asset('assets/img/favicon.png'))" />

        <link type="image/png" href="{{ asset('/assets/img/favicon.png') }}" rel="icon">

        <meta name="robots" content="@yield('meta_robots', 'index,follow')">
        <link href="{{ url()->current() }}" rel="canonical">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet" integrity="sha512-XcIsjKMcuVe0Ucj/xgIXQnytNwBttJbNjltBV18IOnru2lDPe9KRRyvCXw6Y5H415vbBLRm8+q6fmLUU7DfO6Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        @stack('css')
        {{ $css ?? '' }}

        <!-- Scripts -->
        <script>
            (function() {
                if (localStorage.getItem("theme") === "dark") {
                    document.documentElement.classList.add("dark");
                }
            })();
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        @vite(['resources/css/app.css', 'resources/js/app-dashboard.js', 'resources/js/app.js'])
    </head>

    <body class="text-foreground bg-background font-sans antialiased">
        <div class="sticky inset-x-0 top-0 z-20">
            <!-- ========== HEADER ========== -->
            <x-dashboard.app-header />
            <!-- ========== END HEADER ========== -->

            <!-- Breadcrumb Section -->
            <div class="relative -mt-px">
                <div class="border-foreground/30 bg-neutral z-20 border-y px-4 sm:px-6 lg:hidden lg:px-8">
                    <div class="flex items-center py-2">
                        <!-- Navigation Toggle -->
                        <button class="focus:outline-hidden border-foreground/70 text-foreground hover:text-foreground/70 focus:text-foreground/70 flex size-8 items-center justify-center gap-x-2 rounded-md border" data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" aria-expanded="false">
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
            <!-- End Breadcrumb Section -->
        </div>

        <!-- Sidebar -->
        <x-dashboard.app-sidebar />
        <!-- End Sidebar -->

        <!-- ========== MAIN CONTENT ========== -->
        <!-- Content -->
        <main class="relative min-h-screen w-full lg:ps-64">
            <div class="space-y-1 p-2 sm:p-1">
                <!-- your content goes here ... -->

                {{ $slot }}

            </div>
        </main>
        <!-- End Content -->
        <!-- ========== END MAIN CONTENT ========== -->

        <!-- Supporting Components -->
        <x-toast />
        <x-alert-modal />
        <x-dependencies._messageAlert />

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

        <script>
            $(document).on("click", ".zk-delete-data", function(e) {
                e.preventDefault();
                var form = $(this).closest('form'); // Get the closest form
                ZkPopAlert.show({
                    message: "Are you sure you want to delete this data?",
                    confirmText: "Yes, delete it",
                    cancelText: "No, cancel",
                    onConfirm: function() { // Use function() instead of arrow function for better scope handling
                        form.submit();
                    }
                });
            });
        </script>

        @stack('javascript')
        {{ $javascript ?? '' }}
    </body>

</html>
