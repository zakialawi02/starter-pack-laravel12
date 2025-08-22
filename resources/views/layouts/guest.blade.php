<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name'))</title>
        <meta content="@yield('meta_description', '') name="description"">
        <meta name="author" content="Ahmad Zaki Alawi" />

        <link type="image/png" href="{{ asset('/assets/img/favicon.png') }}" rel="icon">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet" integrity="sha512-XcIsjKMcuVe0Ucj/xgIXQnytNwBttJbNjltBV18IOnru2lDPe9KRRyvCXw6Y5H415vbBLRm8+q6fmLUU7DfO6Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            /* Edge (lama) & IE: hilangkan tombol eye & clear */
            input::-ms-reveal,
            input::-ms-clear {
                display: none !important;
            }

            /* WebKit “auto-fill/contact” button (Safari/Chrome varian) */
            ::-webkit-contacts-auto-fill-button {
                visibility: hidden !important;
                display: none !important;
                pointer-events: none !important;
            }

            /* Opsional: netralisir background kuning autofill (kalau terlanjur terisi) */
            input:-webkit-autofill {
                -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
                -webkit-text-fill-color: inherit !important;
                caret-color: inherit !important;
            }
        </style>
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
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">
        {{ $slot }}

        <script>
            function togglePassword(id) {
                const input = document.getElementById(id);
                const icon = document.getElementById('icon-' + id);

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("ri-eye-off-line");
                    icon.classList.add("ri-eye-line");
                } else {
                    input.type = "password";
                    icon.classList.remove("ri-eye-line");
                    icon.classList.add("ri-eye-off-line");
                }
            }
        </script>
        @stack('javascript')
        {{ $javascript ?? '' }}
    </body>

</html>
