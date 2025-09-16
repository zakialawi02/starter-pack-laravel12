@section('title', $data['title'] ?? '')
@section('meta_description', '')

<x-app-layout>
    <section class="p-1 md:p-4">
        <x-card>
            <div class="mb-3 flex items-center justify-end px-2 align-middle">
                <x-button-primary id="createNewUser" data-modal-target="userModal" data-modal-toggle="userModal" type="button">
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

    <!-- Main modal -->
    <div class="z-60 fixed left-0 right-0 top-0 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0" id="userModal" aria-hidden="true" tabindex="-1">
        <div class="relative max-h-full w-full max-w-2xl p-4">
            <!-- Modal content -->
            <div class="bg-background border-border relative rounded-lg border shadow-sm">
                <!-- Modal header -->
                <div class="border-foreground/30 flex items-center justify-between rounded-t border-b p-2 md:p-3">
                    <h3 class="modal-title text-foreground text-xl font-semibold">
                        Add User
                    </h3>
                    <button class="text-foreground/70 hover:bg-background hover:text-foreground ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm" data-modal-hide="userModal" type="button">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="modal-body space-y-2 p-2 md:p-3">
                    <div id="error-messages"></div>

                    <div class="modal-loader-data hidden animate-pulse" role="status">
                        <div class="bg-base-content-muted mx-auto mb-4 h-2.5 w-60 rounded-full"></div>
                        <div class="w-50 bg-base-content-muted mx-auto mb-4 h-2.5 rounded-full"></div>
                        <span class="sr-only">Loading...</span>
                    </div>

                    <form class="" id="userForm" method="post" action="">
                        @csrf
                        <input id="_method" name="_method" type="hidden">

                        <div class="space-y-2.5">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input class="px-1! py-1.5! mt-1 block w-full" id="name" name="name" type="text" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                            </div>

                            <div class="flex w-full flex-col items-center justify-between gap-2 md:flex-row">
                                <!-- Username -->
                                <div class="w-full md:w-1/2">
                                    <x-input-label for="username" :value="__('Username')" />
                                    <x-text-input class="px-1! py-1.5! block w-full" id="username" name="username" type="text" :value="old('username')" required autocomplete="username" placeholder="johndoe" />
                                </div>

                                <!-- role -->
                                <div class="w-full md:w-1/2">
                                    <x-input-label for="role" :value="__('Role')" />
                                    <select class="focus:ring-primary focus:border-primary border-ring bg-input/50 text-foreground block w-full rounded-lg border p-2" id="role" name="role">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4 flex w-full flex-col items-center justify-between gap-2 md:flex-row">

                                <!-- Email Address -->
                                <div class="w-full md:w-1/2">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input class="px-1! py-1.5! mt-1 block w-full" id="email" name="email" type="email" :value="old('email')" required autocomplete="email" placeholder="name@mail.com" />
                                </div>

                                <div class="w-full md:w-1/2">
                                    <x-input-label for="verified" :value="__('Verified Status')" />
                                    <select class="focus:ring-primary focus:border-primary border-ring bg-input/50 text-foreground block w-full rounded-lg border p-2" id="email_verified_at" name="email_verified_at">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input class="px-1! py-1.5! mt-1 block w-full" id="password" name="password" type="password" required autocomplete="new-password" />
                                <span class="text-back-muted" id="passwordHelpBlock"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="border-foreground/30 flex flex-row-reverse items-center gap-2 rounded-b border-t p-2 md:p-3">
                    <x-button-primary id="saveBtn" type="submit">
                        Save
                    </x-button-primary>
                    <x-button-light data-modal-hide="userModal" type="button">
                        Close
                    </x-button-light>
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
                            name: 'role'
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

                const cardErrorMessages = `<div id="body-messages" class="mb-3 rounded-md bg-error/30 p-4 text-sm text-error" role="alert"></div>`;

                const modal = new Modal(document.getElementById('userModal'), {
                    onHide: () => {
                        // Hapus parameter user_id dari URL
                        let newUrl = window.location.pathname;
                        window.history.pushState({
                            path: newUrl
                        }, "", newUrl);
                    },
                });
                document.querySelectorAll("[data-modal-hide]").forEach((button) => {
                    button.addEventListener("click", function() {
                        modal.hide();
                    });
                });


                // Open modal for creating new user
                $('#createNewUser').click(function() {
                    $(".modal-loader-data").hide()
                    $("#userForm").show();
                    $('#userModal').find('.modal-title').text('Add User');
                    $('#userForm').attr('method', 'POST');
                    $('#_method').val('POST');
                    $('#userForm').trigger("reset");
                    $('#userForm').attr('action', '{{ route('admin.users.store') }}');
                    $('#saveBtn').text('Create');
                    $("#error-messages").html("");
                    $("#passwordHelpBlock").html("");
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
                            modal.hide();
                            $('#myTable').DataTable().ajax.reload();
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
                $('body').on('click', '.editUser', function() {
                    $('#userForm').trigger("reset");
                    $(".modal-loader-data").show();
                    $("#userForm").hide();
                    $('#saveBtn').prop('disabled', true);
                    $('#userModal').find('.modal-title').text('Edit User');
                    $("#error-messages").html("");
                    $("#passwordHelpBlock").html("blank if you don't want to change");
                    const userId = $(this).data('id');
                    // Tampilkan ID User di URL tanpa reload halaman
                    let newUrl = window.location.pathname + "?user_id=" + userId;
                    window.history.replaceState({}, '', newUrl);
                    modal.show();
                    getUserData(userId);
                });

                // Delete user
                $('body').on('click', '.deleteUser', function(e) {
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
                            $('#myTable').DataTable().ajax.reload();
                            MyZkToast.success(response.message);
                        },
                        error: function(error) {
                            console.log(error);
                            MyZkToast.error(error.statusText)
                        }
                    });
                }

                // Cek URL saat halaman dimuat
                let params = new URLSearchParams(window.location.search);
                if (params.has("user_id")) {
                    let userId = params.get("user_id");
                    $(".modal-loader-data").show();
                    $("#userForm").hide();
                    $('#saveBtn').prop('disabled', true);
                    $('#userModal').find('.modal-title').text('Edit User');
                    $("#error-messages").html("");
                    $("#passwordHelpBlock").html("blank if you don't want to change");
                    setTimeout(() => {
                        modal.show();
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
