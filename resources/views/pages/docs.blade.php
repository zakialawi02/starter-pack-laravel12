<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net" rel="preconnect">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>

            </style>
        @endif
    </head>

    <body class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <header class="not-has-[nav]:hidden mb-6 w-full max-w-[335px] text-sm lg:max-w-4xl">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]" href="{{ url('/dashboard') }}">
                            Dashboard
                        </a>
                    @else
                        <a class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]" href="{{ route('login') }}">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]" href="{{ route('register') }}">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <div class="duration-750 starting:opacity-0 flex w-full items-center justify-center opacity-100 transition-opacity lg:grow">
            <main class="flex w-full max-w-[335px] flex-col lg:max-w-6xl">

                <div class="py-4">
                    <x-button-primary type="button">
                        <i class="ri-refresh-line"></i>
                        primary
                    </x-button-primary>
                    <x-button-secondary type="button">
                        <i class="ri-refresh-line"> </i>
                        secondary
                    </x-button-secondary>
                    <x-button-light type="button">
                        <i class="ri-refresh-line"></i>
                        light
                    </x-button-light>
                    <x-button-danger type="button">
                        <i class="ri-refresh-line"></i>
                        error
                    </x-button-danger>
                </div>

                <div className="my-5 description">
                    <p>
                        This table provides a complete list of all routes
                        defined in the Laravel application. Each route
                        specifies the HTTP method, the URL path, the
                        controller/action handling the request, middleware
                        applied to the route, and the route name if one is
                        defined. Routes are grouped by authentication roles
                        (superadmin, admin, user) and specific
                        functionalities such as user management,
                        authentication, profile editing, and email
                        verification. The Laravel framework uses these
                        routes to manage the application’s navigation and
                        access control.
                    </p>
                </div>
                <div class="mt-10 overflow-x-auto">
                    <div class="overflow-x-auto rounded-lg shadow-xl">
                        <table class="min-w-full border-collapse divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Method</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">URI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Middleware</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 bg-white">
                                <!-- Guest Routes -->
                                <tr class="bg-blue-50">
                                    <td class="px-6 py-3 text-lg font-semibold text-blue-700" colspan="5">Guest Routes</td>
                                </tr>

                                <!-- Registration -->
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/register</td>
                                    <td class="px-6 py-4 font-mono text-sm">register</td>
                                    <td class="px-6 py-4">guest</td>
                                    <td class="px-6 py-4 font-mono text-sm">RegisteredUserController@create</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">POST</span>
                                    </td>
                                    <td class="px-6 py-4">/register</td>
                                    <td class="px-6 py-4">-</td>
                                    <td class="px-6 py-4">guest</td>
                                    <td class="px-6 py-4 font-mono text-sm">RegisteredUserController@store</td>
                                </tr>

                                <!-- Login -->
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/login</td>
                                    <td class="px-6 py-4 font-mono text-sm">login</td>
                                    <td class="px-6 py-4">guest</td>
                                    <td class="px-6 py-4 font-mono text-sm">AuthenticatedSessionController@create</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">POST</span>
                                    </td>
                                    <td class="px-6 py-4">/login</td>
                                    <td class="px-6 py-4">-</td>
                                    <td class="px-6 py-4">guest</td>
                                    <td class="px-6 py-4 font-mono text-sm">AuthenticatedSessionController@store</td>
                                </tr>

                                <!-- Password Reset -->
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/forgot-password</td>
                                    <td class="px-6 py-4 font-mono text-sm">password.request</td>
                                    <td class="px-6 py-4">guest</td>
                                    <td class="px-6 py-4 font-mono text-sm">PasswordResetLinkController@create</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">POST</span>
                                    </td>
                                    <td class="px-6 py-4">/forgot-password</td>
                                    <td class="px-6 py-4 font-mono text-sm">password.email</td>
                                    <td class="px-6 py-4">guest</td>
                                    <td class="px-6 py-4 font-mono text-sm">PasswordResetLinkController@store</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/reset-password/{token}</td>
                                    <td class="px-6 py-4 font-mono text-sm">password.reset</td>
                                    <td class="px-6 py-4">guest</td>
                                    <td class="px-6 py-4 font-mono text-sm">NewPasswordController@create</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">POST</span>
                                    </td>
                                    <td class="px-6 py-4">/reset-password</td>
                                    <td class="px-6 py-4 font-mono text-sm">password.store</td>
                                    <td class="px-6 py-4">guest</td>
                                    <td class="px-6 py-4 font-mono text-sm">NewPasswordController@store</td>
                                </tr>

                                <!-- Authenticated Routes -->
                                <tr class="bg-blue-50">
                                    <td class="px-6 py-3 text-lg font-semibold text-blue-700" colspan="5">Authenticated Routes</td>
                                </tr>

                                <!-- Email Verification -->
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/verify-email</td>
                                    <td class="px-6 py-4 font-mono text-sm">verification.notice</td>
                                    <td class="px-6 py-4">auth</td>
                                    <td class="px-6 py-4 font-mono text-sm">EmailVerificationPromptController</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/verify-email/{id}/{hash}</td>
                                    <td class="px-6 py-4 font-mono text-sm">verification.verify</td>
                                    <td class="px-6 py-4">auth, signed, throttle:6,1</td>
                                    <td class="px-6 py-4 font-mono text-sm">VerifyEmailController</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">POST</span>
                                    </td>
                                    <td class="px-6 py-4">/email/verification-notification</td>
                                    <td class="px-6 py-4 font-mono text-sm">verification.send</td>
                                    <td class="px-6 py-4">auth, throttle:6,1</td>
                                    <td class="px-6 py-4 font-mono text-sm">EmailVerificationNotificationController@store</td>
                                </tr>

                                <!-- Password Confirmation -->
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/confirm-password</td>
                                    <td class="px-6 py-4 font-mono text-sm">password.confirm</td>
                                    <td class="px-6 py-4">auth</td>
                                    <td class="px-6 py-4 font-mono text-sm">ConfirmablePasswordController@show
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">POST</span>
                                    </td>
                                    <td class="px-6 py-4">/confirm-password</td>
                                    <td class="px-6 py-4">-</td>
                                    <td class="px-6 py-4">auth</td>
                                    <td class="px-6 py-4 font-mono text-sm">ConfirmablePasswordController@store</td>
                                </tr>

                                <!-- Password Update -->
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">PUT</span>
                                    </td>
                                    <td class="px-6 py-4">/password</td>
                                    <td class="px-6 py-4 font-mono text-sm">password.update</td>
                                    <td class="px-6 py-4">auth</td>
                                    <td class="px-6 py-4 font-mono text-sm">PasswordController@update</td>
                                </tr>

                                <!-- Logout -->
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">POST</span>
                                    </td>
                                    <td class="px-6 py-4">/logout</td>
                                    <td class="px-6 py-4 font-mono text-sm">logout</td>
                                    <td class="px-6 py-4">auth</td>
                                    <td class="px-6 py-4 font-mono text-sm">AuthenticatedSessionController@destroy</td>
                                </tr>

                                <!-- Dashboard Routes -->
                                <tr class="bg-blue-50">
                                    <td class="px-6 py-3 text-lg font-semibold text-blue-700" colspan="5">Dashboard Routes</td>
                                </tr>

                                <!-- User Resource -->
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/dashboard/users</td>
                                    <td class="px-6 py-4 font-mono text-sm">admin.users.index</td>
                                    <td class="px-6 py-4">auth, verified</td>
                                    <td class="px-6 py-4 font-mono text-sm">UserController@index</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">POST</span>
                                    </td>
                                    <td class="px-6 py-4">/dashboard/users</td>
                                    <td class="px-6 py-4 font-mono text-sm">admin.users.store</td>
                                    <td class="px-6 py-4">auth, verified</td>
                                    <td class="px-6 py-4 font-mono text-sm">UserController@store</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/dashboard/users/{user}</td>
                                    <td class="px-6 py-4 font-mono text-sm">admin.users.show</td>
                                    <td class="px-6 py-4">auth, verified</td>
                                    <td class="px-6 py-4 font-mono text-sm">UserController@show
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">PUT</span>
                                    </td>
                                    <td class="px-6 py-4">/dashboard/users/{user}</td>
                                    <td class="px-6 py-4 font-mono text-sm">admin.users.update</td>
                                    <td class="px-6 py-4">auth, verified</td>
                                    <td class="px-6 py-4 font-mono text-sm">UserController@update</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">DELETE</span>
                                    </td>
                                    <td class="px-6 py-4">/dashboard/users/{user}</td>
                                    <td class="px-6 py-4 font-mono text-sm">admin.users.destroy</td>
                                    <td class="px-6 py-4">auth, verified</td>
                                    <td class="px-6 py-4 font-mono text-sm">UserController@destroy</td>
                                </tr>

                                <!-- Profile Management -->
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/dashboard</td>
                                    <td class="px-6 py-4 font-mono text-sm">admin.dashboard</td>
                                    <td class="px-6 py-4">auth, verified, role:superadmin,admin,user</td>
                                    <td class="px-6 py-4 font-mono text-sm">Closure</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/dashboard/profile</td>
                                    <td class="px-6 py-4 font-mono text-sm">admin.profile.edit</td>
                                    <td class="px-6 py-4">auth, verified, role:superadmin,admin,user</td>
                                    <td class="px-6 py-4 font-mono text-sm">ProfileController@edit</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">PATCH</span>
                                    </td>
                                    <td class="px-6 py-4">/dashboard/profile</td>
                                    <td class="px-6 py-4 font-mono text-sm">admin.profile.update</td>
                                    <td class="px-6 py-4">auth, verified, role:superadmin,admin,user</td>
                                    <td class="px-6 py-4 font-mono text-sm">ProfileController@update</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800">PATCH</span>
                                    </td>
                                    <td class="px-6 py-4">/dashboard/photo-profile</td>
                                    <td class="px-6 py-4 font-mono text-sm">admin.profile.photo-update</td>
                                    <td class="px-6 py-4">auth, verified, role:superadmin,admin,user</td>
                                    <td class="px-6 py-4 font-mono text-sm">ProfileController@updatePhoto</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">DELETE</span>
                                    </td>
                                    <td class="px-6 py-4">/dashboard/profile</td>
                                    <td class="px-6 py-4 font-mono text-sm">admin.profile.destroy</td>
                                    <td class="px-6 py-4">auth, verified, role:superadmin,admin,user</td>
                                    <td class="px-6 py-4 font-mono text-sm">ProfileController@destroy</td>
                                </tr>

                                <!-- Root Route -->
                                <tr class="bg-blue-50">
                                    <td class="px-6 py-3 text-lg font-semibold text-blue-700" colspan="5">General Routes</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/</td>
                                    <td class="px-6 py-4">-</td>
                                    <td class="px-6 py-4">-</td>
                                    <td class="px-6 py-4 font-mono text-sm">Closure</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">GET</span>
                                    </td>
                                    <td class="px-6 py-4">/docs</td>
                                    <td class="px-6 py-4 font-mono text-sm">docs</td>
                                    <td class="px-6 py-4">-</td>
                                    <td class="px-6 py-4 font-mono text-sm">Closure</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 rounded-lg bg-white p-4 shadow">
                        <h2 class="mb-2 text-lg font-semibold">Legenda:</h2>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center">
                                <span class="mr-2 h-4 w-12 bg-green-100"></span>
                                <span>GET</span>
                            </div>
                            <div class="flex items-center">
                                <span class="mr-2 h-4 w-12 bg-yellow-100"></span>
                                <span>POST</span>
                            </div>
                            <div class="flex items-center">
                                <span class="mr-2 h-4 w-12 bg-blue-100"></span>
                                <span>PUT/PATCH</span>
                            </div>
                            <div class="flex items-center">
                                <span class="mr-2 h-4 w-12 bg-red-100"></span>
                                <span>DELETE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>

</html>
