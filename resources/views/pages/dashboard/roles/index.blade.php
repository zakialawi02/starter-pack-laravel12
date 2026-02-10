@section('title', $data['title'] ?? '')
@section('meta_description', '')

<x-app-layout>
    <section class="p-1 md:p-4">
        <x-card>
            <div class="mb-3 flex items-center justify-end px-2 align-middle">
                <x-button-primary id="create-new-role" data-hs-overlay="#role-modal" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="role-modal">
                    <i class="ri-add-line"></i>
                    <span>Add Role</span>
                </x-button-primary>
            </div>

            <div class="table-container">
                <table class="display table" id="rolesTable">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Permissions</th>
                            <th scope="col">Users</th>
                            <th scope="col">Created</th>
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


    <div class="hs-overlay z-80 pointer-events-none fixed start-0 top-0 hidden size-full overflow-y-auto overflow-x-hidden" id="role-modal" role="dialog" aria-labelledby="role-modal-label" tabindex="-1">
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 m-3 flex min-h-[calc(100%-56px)] scale-95 items-center opacity-0 transition-all duration-200 ease-in-out sm:mx-auto sm:w-full sm:max-w-lg">
            <div class="shadow-2xs border-foreground/20 bg-background pointer-events-auto flex w-full flex-col rounded-xl border">
                <div class="border-foreground/20 flex items-center justify-between border-b px-4 py-3">
                    <h3 class="modal-title text-foreground font-semibold">
                        Add Role
                    </h3>
                    <button class="focus:outline-hidden hover:bg-foreground/20 focus:bg-foreground/20 text-foreground/80 inline-flex size-8 items-center justify-center gap-x-2 rounded-full border border-transparent disabled:pointer-events-none disabled:opacity-50" data-hs-overlay="#role-modal" type="button" aria-label="Close">
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

                    <form class="" id="roleForm" method="post" action="">
                        @csrf
                        <input id="_method" name="_method" type="hidden">

                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Role Name')" />
                                <x-text-input class="px-1! py-1.5! mt-1 block w-full" id="name" name="name" type="text" required autofocus placeholder="e.g. editor" />
                            </div>

                            <!-- Permissions -->
                            <div>
                                <x-input-label :value="__('Permissions')" />
                                <div class="mt-2 grid grid-cols-2 gap-2" id="permissions-container">
                                    @foreach ($permissions as $permission)
                                        <label class="border-foreground/20 hover:bg-muted flex cursor-pointer items-center gap-2 rounded-lg border p-2 text-sm">
                                            <input class="text-primary focus:ring-primary rounded" name="permissions[]" type="checkbox" value="{{ $permission->name }}">
                                            <span>{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="border-foreground/20 flex items-center justify-end gap-x-2 border-t px-4 py-3">
                    <x-button-light class="border-border bg-background text-foreground hover:bg-muted focus:bg-muted inline-flex items-center gap-x-2 rounded-lg border px-3 py-2 text-sm font-medium focus:outline-none disabled:pointer-events-none disabled:opacity-50" data-hs-overlay="#role-modal" type="button">
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
                let table = new DataTable('#rolesTable', {
                    responsive: true,
                    scrollX: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url()->full() }}",
                        beforeSend: function() {
                            dt_showLoader("#rolesTable");
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
                        [1, 'asc']
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            render: function(data) {
                                const badgeMap = {
                                    'superadmin': 'error',
                                    'admin': 'primary',
                                };
                                const badgeClass = badgeMap[data] || 'secondary';
                                return `<span class="badge bg-${badgeClass}">${data}</span>`;
                            }
                        },
                        {
                            data: 'permissions',
                            name: 'permissions',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'users_count',
                            name: 'users_count',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
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

                const cardErrorMessages = `<div id="body-messages" class="mb-3 rounded-md bg-error/30 p-4 text-sm text-error" role="alert"></div>`;

                // Open modal for creating new role
                $('#create-new-role').click(function() {
                    $(".modal-loader-data").hide();
                    $("#roleForm").show();
                    $('#role-modal').find('.modal-title').text('Add Role');
                    $('#roleForm').attr('method', 'POST');
                    $('#_method').val('POST');
                    $('#roleForm').trigger("reset");
                    $('#roleForm').attr('action', '{{ route('admin.roles.store') }}');
                    $('#saveBtn').text('Create');
                    $("#error-messages").html("");
                    // Uncheck all permissions
                    $('#permissions-container input[type="checkbox"]').prop('checked', false);
                });

                // Save new or updated role
                $('#saveBtn').on('click', function(e) {
                    e.preventDefault();
                    const formData = $('#roleForm').serialize();
                    const formAction = $('#roleForm').attr('action');
                    const method = $('#roleForm').attr('method');

                    $.ajax({
                        type: method,
                        url: formAction,
                        data: formData,
                        beforeSend: function() {
                            $("#error-messages").html("");
                            $('#saveBtn').prop('disabled', true);
                        },
                        success: function(response) {
                            closeModal('#role-modal');
                            $('#rolesTable').DataTable().ajax.reload(null, false);
                            MyZkToast.success(response.message);
                        },
                        error: function(error) {
                            displayErrors(error.responseJSON.errors);
                        },
                        complete: function() {
                            $('#saveBtn').prop('disabled', false);
                        }
                    });
                });

                // Edit role
                $('body').on('click', '.edit-role', function() {
                    $('#roleForm').trigger("reset");
                    $(".modal-loader-data").show();
                    $("#roleForm").hide();
                    $('#saveBtn').prop('disabled', true);
                    $('#role-modal').find('.modal-title').text('Edit Role');
                    $("#error-messages").html("");
                    const roleId = $(this).data('id');
                    openModal('#role-modal');
                    getRoleData(roleId);
                });

                // Delete role
                $('body').on('click', '.delete-role', function(e) {
                    e.preventDefault();
                    const roleId = $(this).data('id');

                    ZkPopAlert.show({
                        message: "Are you sure you want to delete this role?",
                        confirmText: "Yes, delete it",
                        cancelText: "No, cancel",
                        onConfirm: () => {
                            deleteRole(roleId);
                        }
                    });
                });

                function deleteRole(roleId) {
                    $.ajax({
                        type: "DELETE",
                        url: `{{ route('admin.roles.destroy', ':roleId') }}`.replace(':roleId', roleId),
                        success: function(response) {
                            $('#rolesTable').DataTable().ajax.reload(null, false);
                            MyZkToast.success(response.message);
                        },
                        error: function(error) {
                            MyZkToast.error(error.responseJSON.message);
                        }
                    });
                }

                function getRoleData(roleId) {
                    $.get(`{{ route('admin.roles.show', ':roleId') }}`.replace(':roleId', roleId))
                        .done(function(data) {
                            $(".modal-loader-data").hide();
                            $("#roleForm").show();
                            $('#saveBtn').prop('disabled', false);
                            $('#roleForm').attr('action', `{{ route('admin.roles.update', ':roleId') }}`.replace(':roleId', roleId));
                            $('#saveBtn').text('Update');
                            $('#_method').val('PUT');
                            $('#name').val(data.name);

                            // Set permissions checkboxes
                            $('#permissions-container input[type="checkbox"]').prop('checked', false);
                            if (data.permissions) {
                                data.permissions.forEach(function(perm) {
                                    $('#permissions-container input[value="' + perm + '"]').prop('checked', true);
                                });
                            }
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            displayErrors({
                                general: [`${textStatus}: ${errorThrown}`]
                            });
                            $(".modal-loader-data").hide();
                            $("#roleForm").hide();
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
