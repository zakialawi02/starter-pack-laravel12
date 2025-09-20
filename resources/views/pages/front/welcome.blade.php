<x-app-front-layout>
    <!-- Navbar -->
    <header class="font-lato relative shadow-md md:shadow-none">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <img class="h-8 w-8 dark:invert" src="{{ asset('/assets/img/logo-crop.png') }}" alt="Logo">
                <span class="text-primary font-bold">Web Title</span>
            </div>

            <!-- Navbar Links -->
            <nav class="bg-background text-foreground absolute left-0 top-[55px] hidden w-full flex-col items-center space-y-3 px-6 py-4 font-bold shadow-lg md:static md:flex md:w-auto md:flex-row md:space-x-6 md:space-y-0 md:bg-transparent md:p-0 md:shadow-none md:transition-none md:duration-0 md:ease-linear md:will-change-auto" id="navbar">

                <a class="text-accent block font-medium md:inline-block" href="/">Home</a>
                <a class="hover:text-primary/70 block md:inline-block" href="#">Menu 1</a>
                <a class="hover:text-primary/70 block md:inline-block" href="#">Menu 2</a>

                <!-- Dropdown -->
                <div class="relative" id="dropdown">
                    <button class="hover:text-primary/70 flex w-full items-center justify-between md:inline-flex md:w-auto" id="dropdown-toggle">
                        Cat Menu <i class="ri-arrow-down-s-line ml-1"></i>
                    </button>
                    <div class="md:bg-background mt-1 hidden flex-col space-y-1 md:absolute md:right-0 md:mt-3 md:w-40 md:rounded-md md:py-2 md:shadow-lg" id="dropdown-menu">
                        <a class="hover:bg-muted block px-2.5 py-1.5" href="#">Sub menu 1</a>
                        <a class="hover:bg-muted block px-2.5 py-1.5" href="#">Sub menu 2</a>
                    </div>
                </div>

                <a class="hover:text-primary/70 block md:inline-block" href="#">Menu 3</a>

                <!-- Auth Menu -->
                @guest
                    <div class="flex flex-col space-y-2 md:flex-row md:space-x-3 md:space-y-0">
                        <a class="border-primary text-primary hover:bg-primary hover:text-background rounded-md border px-3 py-1.5 text-center transition md:inline-block" href="{{ route('login') }}">
                            Login
                        </a>
                        <a class="bg-primary hover:bg-primary/80 text-background rounded-md px-3 py-1.5 text-center transition md:inline-block" href="{{ route('register') }}">
                            Register
                        </a>
                    </div>
                @endguest

                @auth
                    <div class="flex flex-col space-y-2 md:flex-row md:items-center md:space-x-3 md:space-y-0">
                        <a class="bg-accent hover:bg-accent/80 text-background rounded-md px-4 py-1.5 text-center transition md:inline-block" href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="border-error text-error hover:bg-error hover:text-background w-full rounded-md border px-4 py-1.5 transition md:inline-block" type="submit">
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth

            </nav>


            <!-- Mobile Toggle -->
            <button class="focus:outline-none md:hidden" id="navbar-toggle">
                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-8 px-6 py-12 md:grid-cols-2">
        <!-- Text -->
        <div>
            <h1 class="text-3xl font-bold leading-tight md:text-4xl">
                Welcome To <span class="text-primary">Starter Pack Laravel 12</span>
            </h1>
            <p class="text-foreground mt-4 text-lg">
                Laravel 12 + blade + tailwindcss + Basic Auth
            </p>
            <p class="text-foreground/90 mt-3">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste in nam numquam doloribus beatae tempore quas magni eligendi praesentium molestias vero excepturi obcaecati laudantium, nulla laboriosam nemo dolorum similique a...
            </p>
            <div class="mt-6 flex space-x-4">
                <a class="bg-primary text-primary-foreground hover:bg-primary/80 rounded-md px-5 py-2 shadow" href="#">
                    Button 1
                </a>
                <a class="bg-secondary text-secondary-foreground border-secondary/70 hover:bg-secondary/70 rounded-md border px-5 py-2" href="#">
                    Button 2
                </a>
                <a class="border-primary/70 text-primary/70 hover:bg-muted rounded-md border px-5 py-2" href="#">
                    Button 3
                </a>
            </div>
        </div>

        <!-- Image -->
        <div class="flex justify-center">
            <img class="rounded-lg shadow-lg" src="{{ asset('/assets/img/image-placeholder.png') }}" alt="Hero Image">
        </div>
    </section>

    @push('javascript')
        <script>
            const toggleBtn = document.getElementById('navbar-toggle');
            const navbar = document.getElementById('navbar');

            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                navbar.classList.toggle('hidden');
            });

            const dropdownToggle = document.getElementById('dropdown-toggle');
            const dropdownMenu = document.getElementById('dropdown-menu');
            const dropdownWrap = document.getElementById('dropdown');

            dropdownToggle.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });

            // Outside click → tutup navbar & dropdown
            document.addEventListener('click', (e) => {
                if (!navbar.contains(e.target) && !toggleBtn.contains(e.target)) {
                    navbar.classList.add('hidden');
                }
                if (!dropdownWrap.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        </script>
    @endpush

</x-app-front-layout>
