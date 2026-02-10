@section('title', $data['title'] ?? '')
@section('meta_description', '')

<x-app-layout>
    <section class="p-1 md:p-4">
        <x-card>
            <div class="mb-3 flex items-center justify-end px-2 align-middle">
                <x-button-primary id="create-new-permission" data-hs-overlay="#permission-modal" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="permission-modal">
                    <i class="ri-add-line"></i>
                    <span>Add Permission</span>
                </x-button-primary>
            </div>

            <div class="table-container">
                <table class="display table" id="permissionsTable">
                    <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Assigned Roles</th>
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


    <div class="hs-overlay z-80 pointer-events-none fixed start-0 top-0 hidden size-full overflow-y-auto overflow-x-hidden" id="permission-modal" role="dialog" aria-labelledby="permission-modal-label" tabindex="-1">
        <div class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 m-3 flex min-h-[calc(100%-56px)] scale-95 items-center opacity-0 transition-all duration-200 ease-in-out sm:mx-auto sm:w-full sm:max-w-lg">
            <div class="shadow-2xs border-foreground/20 bg-background pointer-events-auto flex w-full flex-col rounded-xl border">
                <div class="border-foreground/20 flex items-center justify-between border-b px-4 py-3">
                    <h3 class="modal-title text-foreground font-semibold">
                        Add Permission
                    </h3>
                    <button class="focus:outline-hidden hover:bg-foreground/20 focus:bg-foreground/20 text-foreground/80 inline-flex size-8 items-center justify-center gap-x-2 rounded-full border border-transparent disabled:pointer-events-none disabled:opacity-50" data-hs-overlay="#permission-modal" type="button" aria-label="Close">
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

                    <form class="" id="permissionForm" method="post" action="">
                        @csrf
                        <input id="_method" name="_method" type="hidden">

                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Permission Name')" />
                                <x-text-input class="px-1! py-1.5! mt-1 block w-full" id="name" name="name" type="text" required autofocus placeholder="e.g. manage-posts" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="border-foreground/20 flex items-center justify-end gap-x-2 border-t px-4 py-3">
                    <x-button-light class="border-border bg-background text-foreground hover:bg-muted focus:bg-muted inline-flex items-center gap-x-2 rounded-lg border px-3 py-2 text-sm font-medium focus:outline-none disabled:pointer-events-none disabled:opacity-50" data-hs-overlay="#permission-modal" type="button">
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
                let table = new DataTable('#permissionsTable', {
                    responsive: true,
                    scrollX: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url()->full() }}",
                        beforeSend: function() {
                            dt_showLoader("#permissionsTable");
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
                            name: 'name'
                        },
                        {
                            data: 'roles',
                            name: 'roles',
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

                // Open modal for creating new permission
                $('#create-new-permission').click(function() {
                    $(".modal-loader-data").hide();
                    $("#permissionForm").show();
                    $('#permission-modal').find('.modal-title').text('Add Permission');
                    $('#permissionForm').attr('method', 'POST');
                    $('#_method').val('POST');
                    $('#permissionForm').trigger("reset");
                    $('#permissionForm').attr('action', '{{ route('admin.permissions.store') }}');
                    $('#saveBtn').text('Create');
                    $("#error-messages").html("");
                });

                // Save new or updated permission
                $('#saveBtn').on('click', function(e) {
                    e.preventDefault();
                    const formData = $('#permissionForm').serialize();
                    const formAction = $('#permissionForm').attr('action');
                    const method = $('#permissionForm').attr('method');

                    $.ajax({
                        type: method,
                        url: formAction,
                        data: formData,
                        beforeSend: function() {
                            $("#error-messages").html("");
                            $('#saveBtn').prop('disabled', true);
                        },
                        success: function(response) {
                            closeModal('#permission-modal');
                            $('#permissionsTable').DataTable().ajax.reload(null, false);
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

                // Edit permission
                $('body').on('click', '.edit-permission', function() {
                    $('#permissionForm').trigger("reset");
                    $(".modal-loader-data").show();
                    $("#permissionForm").hide();
                    $('#saveBtn').prop('disabled', true);
                    $('#permission-modal').find('.modal-title').text('Edit Permission');
                    $("#error-messages").html("");
                    const permissionId = $(this).data('id');
                    openModal('#permission-modal');
                    getPermissionData(permissionId);
                });

                // Delete permission
                $('body').on('click', '.delete-permission', function(e) {
                    e.preventDefault();
                    const permissionId = $(this).data('id');

                    ZkPopAlert.show({
                        message: "Are you sure you want to delete this permission?",
                        confirmText: "Yes, delete it",
                        cancelText: "No, cancel",
                        onConfirm: () => {
                            deletePermission(permissionId);
                        }
                    });
                });

                function deletePermission(permissionId) {
                    $.ajax({
                        type: "DELETE",
                        url: `{{ route('admin.permissions.destroy', ':permissionId') }}`.replace(':permissionId', permissionId),
                        success: function(response) {
                            $('#permissionsTable').DataTable().ajax.reload(null, false);
                            MyZkToast.success(response.message);
                        },
                        error: function(error) {
                            MyZkToast.error(error.responseJSON.message);
                        }
                    });
                }

                function getPermissionData(permissionId) {
                    $.get(`{{ route('admin.permissions.show', ':permissionId') }}`.replace(':permissionId', permissionId))
                        .done(function(data) {
                            $(".modal-loader-data").hide();
                            $("#permissionForm").show();
                            $('#saveBtn').prop('disabled', false);
                            $('#permissionForm').attr('action', `{{ route('admin.permissions.update', ':permissionId') }}`.replace(':permissionId', permissionId));
                            $('#saveBtn').text('Update');
                            $('#_method').val('PUT');
                            $('#name').val(data.name);
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            displayErrors({
                                general: [`${textStatus}: ${errorThrown}`]
                            });
                            $(".modal-loader-data").hide();
                            $("#permissionForm").hide();
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
