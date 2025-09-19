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
                if (localStorage.getItem("hs_theme") === "dark") {
                    document.documentElement.classList.add("dark");
                }
            })();
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        @vite(['resources/css/app.css', 'resources/js/app-dashboard.js', 'resources/js/app.js'])
    </head>

    <body class="text-foreground bg-background font-sans antialiased">
        <!-- ========== MAIN HEADER ========== -->
        <x-dashboard.app-header />
        <!-- ========== END MAIN HEADER ========== -->

        <!-- ========== MAIN SIDEBAR ========== -->
        <x-dashboard.app-sidebar />
        <!-- ========== END MAIN SIDEBAR ========== -->

        <!-- ========== MAIN CONTENT ========== -->
        <main class="lg:hs-overlay-layout-open:ps-60 bg-background pt-15 px-3 pb-3 transition-all duration-300 lg:fixed lg:inset-0">
            <div class="shadow-xs border-foreground/25 bg-neutral flex h-[calc(100dvh-62px)] flex-col overflow-hidden rounded-lg border lg:h-full">
                <!-- Body -->
                <div class="flex flex-1 flex-col overflow-y-auto [&::-webkit-scrollbar]:w-0">
                    <div class="flex flex-1 flex-col lg:flex-row">
                        <div class="border-foreground/25 flex min-w-0 flex-1 flex-col border-e p-3">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
                <!-- End Body -->
            </div>
        </main>
        <!-- ========== END MAIN CONTENT ========== -->


        <!-- Supporting Components -->
        <x-toast />
        <x-alert-modal />
        <x-dependencies._messageAlert />


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
