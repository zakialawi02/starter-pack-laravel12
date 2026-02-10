@section('title', $data['title'] ?? '')
@section('meta_description', '')

<x-app-layout>
    <section class="p-1 md:p-4">
        <x-card>
            <div class="mb-3 flex items-center justify-end px-2 align-middle">
                <x-button-primary id="create-new-user" data-hs-overlay="#user-modal" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="user-modal">
                    <i class="ri-user-add-line"></i>
                    <span>Add User</span>
                </x-button-primary>
            </div>

            <div class="table-container">
                <table class="display table" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Registered</th>
                            <th scope="col">Verified</th>
                            <th scope="col">Social Login</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ajax datatable -->
                    </tbody>
                </table>
            </div>
        </x-card>
    </section>


    <div class="hs-overlay z-80 pointer-events-none fixed start-0 top-0 hidden size-full overflow-y-auto overflow-x-hidden" id="user-modal" role="dialog" aria-labelledby="user-modal-label" tabindex="-1">
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 m-3 flex min-h-[calc(100%-56px)] scale-95 items-center opacity-0 transition-all duration-200 ease-in-out sm:mx-auto sm:w-full sm:max-w-lg">
            <div class="shadow-2xs border-foreground/20 bg-background pointer-events-auto flex w-full flex-col rounded-xl border">
                <div class="border-foreground/20 flex items-center justify-between border-b px-4 py-3">
                    <h3 class="modal-title text-foreground font-semibold">
                        Add User
                    </h3>
                    <button class="focus:outline-hidden hover:bg-foreground/20 focus:bg-foreground/20 text-foreground/80 inline-flex size-8 items-center justify-center gap-x-2 rounded-full border border-transparent disabled:pointer-events-none disabled:opacity-50" data-hs-overlay="#user-modal" type="button" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"></path>
                            <path d="m6 6 12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="modal-body overflow-y-auto p-4">
                    <div id="error-messages"></div>

                    <div class="modal-loader-data hidden" role="status">
                        <div class="flex animate-pulse flex-col gap-4">
                            <div class="bg-muted h-4 w-3/4 rounded-full"></div>
                            <div class="bg-muted h-4 rounded-full"></div>
                            <div class="bg-muted h-4 w-5/6 rounded-full"></div>
                        </div>
                        <span class="sr-only">Loading...</span>
                    </div>

                    <form class="" id="userForm" method="post" action="">
                        @csrf
                        <input id="_method" name="_method" type="hidden">

                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input class="px-1! py-1.5! mt-1 block w-full" id="name" name="name" type="text" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <!-- Username -->
                                <div>
                                    <x-input-label for="username" :value="__('Username')" />
                                    <x-text-input class="px-1! py-1.5! block w-full" id="username" name="username" type="text" :value="old('username')" required autocomplete="username" placeholder="johndoe" />
                                </div>

                                <!-- role -->
                                <div>
                                    <x-input-label for="role" :value="__('Role')" />
                                    <x-select-input id="role" name="role">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </x-select-input>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <!-- Email Address -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input class="px-1! py-1.5! mt-1 block w-full" id="email" name="email" type="email" :value="old('email')" required autocomplete="email" placeholder="name@mail.com" />
                                </div>

                                <div>
                                    <x-input-label for="verified" :value="__('Verified Status')" />
                                    <x-select-input id="email_verified_at" name="email_verified_at">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </x-select-input>
                                </div>
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input class="px-1! py-1.5! mt-1 block w-full" id="password" name="password" type="password" required autocomplete="new-password" />
                                <p class="text-muted mt-2 text-sm" id="passwordHelpBlock">Minimum 8 characters</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="border-foreground/20 flex items-center justify-end gap-x-2 border-t px-4 py-3">
                    <x-button-light class="border-border bg-background text-foreground hover:bg-muted focus:bg-muted inline-flex items-center gap-x-2 rounded-lg border px-3 py-2 text-sm font-medium focus:outline-none disabled:pointer-events-none disabled:opacity-50" data-hs-overlay="#user-modal" type="button">
                        Close
                    </x-button-light>
                    <x-button-primary id="saveBtn" type="submit">
                        Save
                    </x-button-primary>
                </div>
            </div>
        </div>
    </div>


    @include('components.dependencies._datatables')

    @push('javascript')
        <script>
            $(document).ready(function() {
                let urlParams = new URLSearchParams(window.location.search);
                let pageParam = parseInt(urlParams.get('page')) || 1; // Ambil halaman dari URL
                let limitParam = parseInt(urlParams.get('limit')) || 10;

                let table = new DataTable('#myTable', {
                    responsive: true,
                    scrollX: true,
                    processing: true,
                    serverSide: true,
                    displayStart: (pageParam - 1) * limitParam, // Atur posisi awal paging
                    pageLength: limitParam,
                    ajax: {
                        url: "{{ url()->full() }}",
                        beforeSend: function() {
                            dt_showLoader("#myTable");
                        },
                        complete: function() {
                            dt_hideLoader();
                        }
                    },
                    lengthMenu: [
                        [10, 15, 25, 50, -1],
                        [10, 15, 25, 50, "All"]
                    ],
                    language: {
                        paginate: {
                            previous: '<i class="ri-arrow-left-s-line"></i>',
                            next: '<i class="ri-arrow-right-s-line"></i>'
                        }
                    },
                    order: [
                        [2, 'asc']
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'photo',
                            name: 'photo',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role',

                            render: function(data, type, row) {
                                const badgeMap = {
                                    'superadmin': 'error',
                                    'admin': 'primary',
                                };
                                const badgeClass = badgeMap[data] || 'secondary';
                                return `<span class="badge bg-${badgeClass}">${data}</span>`;
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            render: function(data) {
                                return formatCustomDate(data);
                            }
                        },
                        {
                            data: 'email_verified_at',
                            name: 'email_verified_at',
                            render: function(data) {
                                return formatCustomDate(data);
                            }
                        },
                        {
                            data: 'provider_name',
                            name: 'provider_name',
                            render: function(data) {
                                return data ? '<i class="ri-checkbox-circle-line"></i>' : ''
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                // Handle pagination URL updates
                table.on('draw', function() {
                    var info = table.page.info();
                    var currentPage = info.page + 1;
                    var pageLength = info.length;

                    // Update URL parameters
                    var newUrl = new URL(window.location);
                    newUrl.searchParams.set('page', currentPage);
                    newUrl.searchParams.set('limit', pageLength);
                    window.history.replaceState({}, '', newUrl);
                });

                const modalInstance = HSOverlay.getInstance('#user-modal', true);
                if (modalInstance && modalInstance.element) {
                    // Listen for the close event
                    modalInstance.element.on('close', function() {
                        // Remove user_id parameter from URL if present
                        let url = new URL(window.location);
                        if (url.searchParams.has('user_id')) {
                            url.searchParams.delete('user_id');
                            window.history.replaceState({}, '', url);
                        }
                    });
                }

                const cardErrorMessages = `<div id="body-messages" class="mb-3 rounded-md bg-error/30 p-4 text-sm text-error" role="alert"></div>`;

                // Open modal for creating new user
                $('#create-new-user').click(function() {
                    $(".modal-loader-data").hide()
                    $("#userForm").show();
                    $('#user-modal').find('.modal-title').text('Add User');
                    $('#userForm').attr('method', 'POST');
                    $('#_method').val('POST');
                    $('#userForm').trigger("reset");
                    $('#userForm').attr('action', '{{ route('admin.users.store') }}');
                    $('#saveBtn').text('Create');
                    $("#error-messages").html("");
                    $("#passwordHelpBlock").html("");

                    // Enable fields by default for new users
                    $('#email').prop('disabled', false);
                    $('#password').prop('disabled', false);
                    $('#email').removeClass('bg-gray-100');
                    $('#password').removeClass('bg-gray-100');
                    $('#social-login-note').remove();
                });

                // Save new or updated user
                $('#saveBtn').on('click', function(e) {
                    e.preventDefault();
                    const formData = $('#userForm').serialize();
                    const formAction = $('#userForm').attr('action');
                    const method = $('#userForm').attr('method');

                    $.ajax({
                        type: method,
                        url: formAction,
                        data: formData,
                        beforeSend: function() {
                            $("#error-messages").html("");
                            $('#saveBtn').prop('disabled', true);
                        },
                        success: function(response) {
                            closeModal('#user-modal');
                            $('#myTable').DataTable().ajax.reload(null, false);
                            MyZkToast.success(response.message);
                        },
                        error: function(error) {
                            // console.log(messages);
                            displayErrors(error.responseJSON.errors);
                        },
                        complete: function() {
                            $('#saveBtn').prop('disabled', false);
                        }
                    });
                });

                // Edit user
                $('body').on('click', '.edit-user', function() {
                    $('#userForm').trigger("reset");
                    $(".modal-loader-data").show();
                    $("#userForm").hide();
                    $('#saveBtn').prop('disabled', true);
                    $('#user-modal').find('.modal-title').text('Edit User');
                    $("#error-messages").html("");
                    $("#passwordHelpBlock").html("blank if you don't want to change");
                    const userId = $(this).data('id');
                    // Tampilkan ID User di URL tanpa reload halaman
                    let newUrl = new URL(window.location);
                    newUrl.searchParams.set('user_id', userId);
                    window.history.pushState({}, '', newUrl);
                    openModal('#user-modal');
                    getUserData(userId);
                });

                // Delete user
                $('body').on('click', '.delete-user', function(e) {
                    e.preventDefault();
                    const userId = $(this).data('id');
                    const url = `{{ route('admin.users.destroy', ':userId') }}`.replace(':userId', userId);

                    ZkPopAlert.show({
                        message: "Are you sure you want to delete this user?",
                        confirmText: "Yes, delete it",
                        cancelText: "No, cancel",
                        onConfirm: () => {
                            deleteUser(userId);
                        }
                    });
                });

                function deleteUser(userId) {
                    $.ajax({
                        type: "DELETE",
                        url: `{{ route('admin.users.destroy', ':userId') }}`.replace(':userId', userId),
                        success: function(response) {
                            $('#myTable').DataTable().ajax.reload(null, false);
                            MyZkToast.success(response.message);
                        },
                        error: function(error) {
                            console.log(error);
                            MyZkToast.error(error.responseJSON.message)
                        }
                    });
                }

                // Cek URL saat halaman dimuat
                if (urlParams.has("user_id")) {
                    let userId = urlParams.get("user_id");
                    $(".modal-loader-data").show();
                    $("#userForm").hide();
                    $('#saveBtn').prop('disabled', true);
                    $('#user-modal').find('.modal-title').text('Edit User');
                    $("#error-messages").html("");
                    $("#passwordHelpBlock").html("blank if you don't want to change");
                    setTimeout(() => {
                        openModal('#user-modal');
                    }, 800);
                    getUserData(userId);
                }

                function getUserData(userId) {
                    // Panggil AJAX untuk menampilkan data user_id
                    $.get(`{{ route('admin.users.show', ':userId') }}`.replace(':userId', userId))
                        .done(function(data) {
                            $(".modal-loader-data").hide();
                            $("#userForm").show();
                            $('#saveBtn').prop('disabled', false);
                            $('#userForm').attr('action', `{{ route('admin.users.update', ':userId') }}`.replace(':userId', userId));
                            $('#saveBtn').text('Update');
                            $('#_method').val('PUT');
                            $('#name').val(data.name);
                            $('#username').val(data.username);
                            $('#role').val(data.role);
                            $('#email').val(data.email);
                            $('#email_verified_at').val(data.email_verified_at ? 1 : 0);

                            // Check if user logged in via social authentication
                            if (data.provider_name) {
                                // Disable email and password fields for social login users
                                $('#email').prop('disabled', true);
                                $('#password').prop('disabled', true);
                                // Add visual indication
                                $('#email').addClass('bg-gray-100');
                                $('#password').addClass('bg-gray-100');
                                // Add note about social login
                                if ($('#social-login-note').length === 0) {
                                    $('#password').after('<p id="social-login-note" class="text-muted mt-2 text-sm">Email and Password fields is disabled for social login users</p>');
                                }
                            } else {
                                // Enable fields for regular users
                                $('#email').prop('disabled', false);
                                $('#password').prop('disabled', false);
                                $('#email').removeClass('bg-gray-100');
                                $('#password').removeClass('bg-gray-100');
                                $('#social-login-note').remove();
                            }
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            console.error("Error fetching user data:", textStatus, errorThrown);
                            displayErrors({
                                general: [`${textStatus}: ${errorThrown}`]
                            });
                            $(".modal-loader-data").hide();
                            $("#userForm").hide();
                            $('#saveBtn').prop('disabled', true);
                        });

                }

                function displayErrors(errors = {}) {
                    $('#error-messages').html(cardErrorMessages);
                    Object.values(errors).forEach((message) => {
                        $('#body-messages').append(`<span>${message[0]}</span><br>`);
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
