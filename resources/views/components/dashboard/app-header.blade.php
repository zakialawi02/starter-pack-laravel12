<header class="z-36 lg:ps-65 dark:bg-dark-base-100 flex w-full flex-wrap border-b border-gray-200 bg-white py-2.5 text-sm md:flex-nowrap md:justify-start dark:border-slate-700">
    <nav class="mx-auto flex w-full basis-full items-center px-4 sm:px-6">
        <div class="me-5 lg:me-0 lg:hidden">
            <!-- Logo -->
            <a class="focus:outline-hidden inline-block flex-none rounded-md text-xl font-semibold focus:opacity-80" href="#" aria-label="Preline">
                <img class="h-auto max-w-24" src="{{ asset('assets/img/logo.png') }}" alt="Logo Application">
            </a>
            <!-- End Logo -->

            <div class="ms-1 lg:hidden">

            </div>
        </div>

        <div class="ms-auto flex w-full items-center justify-end gap-x-1 md:gap-x-3">
            <button class="p-1 transition duration-300" id="theme-toggle" type="button" title="Toggle dark mode">
                <svg class="hidden h-6 w-6 text-gray-500 dark:text-white" id="icon-sun" data-name="Layer 1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 122.88">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #fcdb33;
                            }
                        </style>
                    </defs>
                    <path class="cls-1" d="M30,13.21A3.93,3.93,0,1,1,36.8,9.27L41.86,18A3.94,3.94,0,1,1,35.05,22L30,13.21Zm31.45,13A35.23,35.23,0,1,1,36.52,36.52,35.13,35.13,0,0,1,61.44,26.2ZM58.31,4A3.95,3.95,0,1,1,66.2,4V14.06a3.95,3.95,0,1,1-7.89,0V4ZM87.49,10.1A3.93,3.93,0,1,1,94.3,14l-5.06,8.76a3.93,3.93,0,1,1-6.81-3.92l5.06-8.75ZM109.67,30a3.93,3.93,0,1,1,3.94,6.81l-8.75,5.06a3.94,3.94,0,1,1-4-6.81L109.67,30Zm9.26,28.32a3.95,3.95,0,1,1,0,7.89H108.82a3.95,3.95,0,1,1,0-7.89Zm-6.15,29.18a3.93,3.93,0,1,1-3.91,6.81l-8.76-5.06A3.93,3.93,0,1,1,104,82.43l8.75,5.06ZM92.89,109.67a3.93,3.93,0,1,1-6.81,3.94L81,104.86a3.94,3.94,0,0,1,6.81-4l5.06,8.76Zm-28.32,9.26a3.95,3.95,0,1,1-7.89,0V108.82a3.95,3.95,0,1,1,7.89,0v10.11Zm-29.18-6.15a3.93,3.93,0,0,1-6.81-3.91l5.06-8.76A3.93,3.93,0,1,1,40.45,104l-5.06,8.75ZM13.21,92.89a3.93,3.93,0,1,1-3.94-6.81L18,81A3.94,3.94,0,1,1,22,87.83l-8.76,5.06ZM4,64.57a3.95,3.95,0,1,1,0-7.89H14.06a3.95,3.95,0,1,1,0,7.89ZM10.1,35.39A3.93,3.93,0,1,1,14,28.58l8.76,5.06a3.93,3.93,0,1,1-3.92,6.81L10.1,35.39Z" />
                </svg>
                <svg class="h-6 w-6 text-gray-600 dark:text-white" id="icon-moon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.3807 2.01886C9.91573 3.38768 9 5.3369 9 7.49999C9 11.6421 12.3579 15 16.5 15C18.6631 15 20.6123 14.0843 21.9811 12.6193C21.6613 17.8537 17.3149 22 12 22C6.47715 22 2 17.5228 2 12C2 6.68514 6.14629 2.33869 11.3807 2.01886Z"></path>
                </svg>
            </button>

            <div class="flex flex-row items-center justify-end gap-1">
                <button class="relative inline-flex items-center space-x-3 text-center text-sm font-medium text-gray-500 hover:text-gray-900 focus:outline-none dark:text-gray-400 dark:hover:text-white" id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification" data-dropdown-offset-distance="20" type="button">
                    <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                        <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
                    </svg>
                    <div class="absolute -top-0.5 start-2.5 block h-3 w-3 rounded-full border-2 border-white bg-red-500 dark:border-gray-900"></div>
                </button>
                <!-- Dropdown menu -->
                <div class="dark:bg-dark-base-200 z-20 hidden w-full max-w-sm divide-y divide-gray-100 rounded-lg bg-white shadow-sm dark:divide-gray-700" id="dropdownNotification" aria-labelledby="dropdownNotificationButton">
                    <div class="dark:bg-dark-base-200 block rounded-t-lg bg-gray-50 px-4 py-2 text-center font-medium text-gray-700 dark:text-white">
                        Notifications
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        <a class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700" href="#">
                            <div class="shrink-0">
                                <img class="h-11 w-11 rounded-full" src="/docs/images/people/profile-picture-1.jpg" alt="Jese image">
                                <div class="absolute -mt-5 ms-6 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-blue-600 dark:border-gray-800">
                                    <svg class="h-2 w-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                                        <path d="M1 18h16a1 1 0 0 0 1-1v-6h-4.439a.99.99 0 0 0-.908.6 3.978 3.978 0 0 1-7.306 0 .99.99 0 0 0-.908-.6H0v6a1 1 0 0 0 1 1Z" />
                                        <path d="M4.439 9a2.99 2.99 0 0 1 2.742 1.8 1.977 1.977 0 0 0 3.638 0A2.99 2.99 0 0 1 13.561 9H17.8L15.977.783A1 1 0 0 0 15 0H3a1 1 0 0 0-.977.783L.2 9h4.239Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="w-full ps-3">
                                <div class="mb-1.5 text-sm text-gray-500 dark:text-gray-400">New message from <span class="font-semibold text-gray-900 dark:text-white">Jese Leos</span>: "Hey, what's up? All set for the presentation?"</div>
                                <div class="text-xs text-blue-600 dark:text-blue-500">a few moments ago</div>
                            </div>
                        </a>
                        <a class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700" href="#">
                            <div class="shrink-0">
                                <img class="h-11 w-11 rounded-full" src="/docs/images/people/profile-picture-2.jpg" alt="Joseph image">
                                <div class="absolute -mt-5 ms-6 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-gray-900 dark:border-gray-800">
                                    <svg class="h-2 w-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                        <path d="M6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Zm11-3h-2V5a1 1 0 0 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 0 0 2 0V9h2a1 1 0 1 0 0-2Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="w-full ps-3">
                                <div class="mb-1.5 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold text-gray-900 dark:text-white">Joseph Mcfall</span> and <span class="font-medium text-gray-900 dark:text-white">5 others</span> started following you.</div>
                                <div class="text-xs text-blue-600 dark:text-blue-500">10 minutes ago</div>
                            </div>
                        </a>
                        <a class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700" href="#">
                            <div class="shrink-0">
                                <img class="h-11 w-11 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="Bonnie image">
                                <div class="absolute -mt-5 ms-6 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-red-600 dark:border-gray-800">
                                    <svg class="h-2 w-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                        <path d="M17.947 2.053a5.209 5.209 0 0 0-3.793-1.53A6.414 6.414 0 0 0 10 2.311 6.482 6.482 0 0 0 5.824.5a5.2 5.2 0 0 0-3.8 1.521c-1.915 1.916-2.315 5.392.625 8.333l7 7a.5.5 0 0 0 .708 0l7-7a6.6 6.6 0 0 0 2.123-4.508 5.179 5.179 0 0 0-1.533-3.793Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="w-full ps-3">
                                <div class="mb-1.5 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold text-gray-900 dark:text-white">Bonnie Green</span> and <span class="font-medium text-gray-900 dark:text-white">141 others</span> love your story. See it and view more stories.</div>
                                <div class="text-xs text-blue-600 dark:text-blue-500">44 minutes ago</div>
                            </div>
                        </a>
                        <a class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700" href="#">
                            <div class="shrink-0">
                                <img class="h-11 w-11 rounded-full" src="/docs/images/people/profile-picture-4.jpg" alt="Leslie image">
                                <div class="absolute -mt-5 ms-6 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-green-400 dark:border-gray-800">
                                    <svg class="h-2 w-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                        <path d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="w-full ps-3">
                                <div class="mb-1.5 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold text-gray-900 dark:text-white">Leslie Livingston</span> mentioned you in a comment: <span class="font-medium text-blue-500" href="#">@bonnie.green</span> what do you say?</div>
                                <div class="text-xs text-blue-600 dark:text-blue-500">1 hour ago</div>
                            </div>
                        </a>
                        <a class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700" href="#">
                            <div class="shrink-0">
                                <img class="h-11 w-11 rounded-full" src="/docs/images/people/profile-picture-5.jpg" alt="Robert image">
                                <div class="absolute -mt-5 ms-6 flex h-5 w-5 items-center justify-center rounded-full border border-white bg-purple-500 dark:border-gray-800">
                                    <svg class="h-2 w-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                                        <path d="M11 0H2a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm8.585 1.189a.994.994 0 0 0-.9-.138l-2.965.983a1 1 0 0 0-.685.949v8a1 1 0 0 0 .675.946l2.965 1.02a1.013 1.013 0 0 0 1.032-.242A1 1 0 0 0 20 12V2a1 1 0 0 0-.415-.811Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="w-full ps-3">
                                <div class="mb-1.5 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold text-gray-900 dark:text-white">Robert Brown</span> posted a new video: Glassmorphism - learn how to implement the new design trend.</div>
                                <div class="text-xs text-blue-600 dark:text-blue-500">3 hours ago</div>
                            </div>
                        </a>
                    </div>
                    <a class="dark:bg-dark-base-200 block rounded-b-lg bg-gray-50 py-2 text-center text-sm font-medium text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" href="#">
                        <div class="inline-flex items-center">
                            <svg class="me-2 h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                                <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                            </svg>
                            View all
                        </div>
                    </a>
                </div>
                <!-- End Dropdown -->

                <button class="flex rounded-full bg-gray-800 text-sm focus:ring-4 focus:ring-gray-300 md:me-0 dark:focus:ring-gray-600" id="user-menu-button" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom" type="button" aria-expanded="false">
                    <span class="sr-only">Open user menu</span>
                    <img class="h-8 w-8 rounded-full" src={{ Auth::user()->profile_photo_path }} alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div class="dark:bg-dark-base-200 z-50 my-4 hidden list-none divide-y divide-gray-100 rounded-lg bg-white text-base shadow-sm dark:divide-slate-600" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900 dark:text-white">{{ Str::limit(Auth::user()->name, 25) }}</span>
                        <span class="block truncate text-sm text-gray-500 dark:text-gray-400">{{ Str::limit(Auth::user()->email, 25) }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white" href={{ route('admin.profile.edit') }}>Profile</a>
                        </li>
                        <li>
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white" href="#">Settings</a>
                        </li>
                        <li>
                            <form class="block w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-start" type="submit">Sign out</button>
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- End Dropdown -->
            </div>
        </div>
    </nav>
</header>
