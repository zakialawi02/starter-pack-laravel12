@section('title', $data['title'] ?? '')
@section('meta_description', '')

<x-app-layout>
    <section class="p-3 md:p-6">
        <!-- Header Section -->
        <div class="mb-4 md:mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-foreground">{{ $data['title'] ?? 'Users Management' }}</h1>
                <p class="text-muted-foreground text-sm mt-1">Manage users in the system.</p>
            </div>
            <div class="flex items-center gap-3">
                <x-button-light id="export-users" class="flex items-center gap-2 border-border bg-background hover:bg-muted font-semibold">
                    <i class="ri-download-2-line"></i>
                    <span>Export</span>
                </x-button-light>
                <x-button-light id="batch-import-user" data-hs-overlay="#import-modal" class="flex items-center gap-2 border-border bg-background hover:bg-muted font-semibold">
                    <i class="ri-upload-2-line"></i>
                    <span>Import</span>
                </x-button-light>
                <x-button-primary id="create-new-user" data-hs-overlay="#user-modal" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="user-modal"
                    class="flex items-center gap-2 font-semibold">
                    <i class="ri-user-add-line"></i>
                    <span>Add New User</span>
                </x-button-primary>
            </div>
        </div>

        <x-card class="overflow-hidden border-none shadow-md">
            <!-- Filter & Search Bar -->
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between px-2 pt-2">
                <div class="flex flex-1 items-center gap-3 max-w-2xl">
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-4">
                            <i class="ri-search-line text-muted-foreground"></i>
                        </div>
                        <input type="text" id="custom-search"
                            class="block w-full rounded-xl border-border bg-background py-2.5 ps-11 pe-10 text-sm focus:border-primary focus:ring-primary transition-all"
                            placeholder="Filter by name, email, or role..." value="{{ request('search') }}">
                        <button id="clear-search"
                            class="absolute inset-y-0 end-0 flex items-center pe-4 text-muted-foreground hover:text-foreground transition-colors {{ request('search') ? '' : 'hidden' }}">
                            <i class="ri-close-circle-fill text-lg"></i>
                        </button>
                    </div>

                    <!-- Role Filter Dropdown -->
                    <div class="hs-dropdown relative inline-flex">
                        <button id="hs-dropdown-role-filter" type="button"
                            class="hs-dropdown-toggle flex items-center justify-center rounded-xl border border-border bg-background p-2.5 text-muted-foreground hover:bg-muted transition-colors">
                            <i class="ri-filter-3-line text-lg"></i>
                        </button>

                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-48 bg-background border border-border shadow-md rounded-xl p-2 mt-2 z-10"
                            aria-labelledby="hs-dropdown-role-filter">
                            <p class="px-3 py-2 text-xs font-bold text-muted-foreground uppercase tracking-wider">Filter
                                by Role</p>
                            <div class="h-px bg-border my-1"></div>
                            <button type="button"
                                class="flex w-full items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-foreground hover:bg-muted focus:outline-hidden role-filter-item {{ !request('role') ? 'bg-primary/10 text-primary font-medium' : '' }}"
                                data-role="">
                                All Roles
                            </button>
                            @foreach ($roles as $role)
                                <button type="button"
                                    class="flex w-full items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-foreground hover:bg-muted focus:outline-hidden role-filter-item {{ request('role') == $role->value ? 'bg-primary/10 text-primary font-medium' : '' }}"
                                    data-role="{{ $role->value }}">
                                    {{ ucfirst($role->value) }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <button id="batch-delete-btn" class="hidden flex items-center gap-2 rounded-xl bg-error px-4 py-2.5 text-sm font-semibold text-white hover:bg-error/90 transition-all shadow-sm">
                        <i class="ri-delete-bin-line"></i>
                        <span>Delete Selected</span>
                    </button>
                </div>
            </div>

            <div class="table-container">
                <table class="w-full text-left border-collapse" id="myTable">
                    <thead>
                        <tr class="bg-background/50 text-muted-foreground uppercase text-[10px] font-bold tracking-widest border-y border-border/50">
                            <th scope="col" class="px-2 py-2 w-10 text-center">
                                <input type="checkbox" id="check-all" class="size-4 rounded border-border text-primary focus:ring-primary transition-all cursor-pointer">
                            </th>
                            <th scope="col" class="px-4 py-2">Name</th>
                            <th scope="col" class="px-6 py-2">Username</th>
                            <th scope="col" class="px-6 py-2">Role</th>
                            <th scope="col" class="px-6 py-2">Created</th>
                            <th scope="col" class="px-6 py-2 text-center">Verified</th>
                            <th scope="col" class="px-6 py-2 text-center">Social Login</th>
                            <th scope="col" class="px-6 py-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        <!-- Ajax datatable -->
                    </tbody>
                </table>
            </div>
        </x-card>
    </section>

    <!-- User Modal -->
    <div class="hs-overlay z-80 pointer-events-none fixed start-0 top-0 hidden size-full overflow-y-auto overflow-x-hidden" id="user-modal" role="dialog" aria-labelledby="user-modal-label"
        tabindex="-1">
        <div
            class="hs-overlay-animation-target hs-overlay-open:scale-100 hs-overlay-open:opacity-100 m-3 flex min-h-[calc(100%-56px)] scale-95 items-center opacity-0 transition-all duration-200 ease-in-out sm:mx-auto sm:w-full sm:max-w-lg">
            <div class="shadow-2xl border-foreground/20 bg-background pointer-events-auto flex w-full flex-col rounded-2xl border">
                <div class="border-foreground/20 flex items-center justify-between border-b px-6 py-4">
                    <h3 class="modal-title text-foreground font-bold text-lg">
                        Add User
                    </h3>
                    <button class="focus:outline-hidden hover:bg-foreground/10 text-foreground/80 inline-flex size-9 items-center justify-center rounded-full transition-colors"
                        data-hs-overlay="#user-modal" type="button" aria-label="Close">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>
                <div class="modal-body overflow-y-auto p-6">
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

                        <div class="space-y-5">
                            <!-- Name -->
                            <div>
                                <x-input-label class="uppercase" for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus autocomplete="name" placeholder="Full Name" />
                            </div>

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <!-- Username -->
                                <div>
                                    <x-input-label class="uppercase" for="username" :value="__('Username')" />
                                    <x-text-input id="username" name="username" type="text" :value="old('username')" required autocomplete="username" placeholder="johndoe" />
                                    <p id="usernameHelpBlock" class="mt-2 text-[10px] text-error font-medium italic hidden"></p>
                                </div>

                                <!-- role -->
                                <div>
                                    <x-input-label class="uppercase" for="role" :value="__('Role')" />
                                    <x-select-input id="role" name="role">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->value }}">{{ $role->label() }}</option>
                                        @endforeach
                                    </x-select-input>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <!-- Email Address -->
                                <div>
                                    <x-input-label class="uppercase" for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" :value="old('email')" required autocomplete="email" placeholder="name@mail.com" />
                                </div>

                                <div>
                                    <x-input-label class="uppercase" for="verified" :value="__('Verified Status')" />
                                    <x-select-input id="email_verified_at" name="email_verified_at">
                                        <option value="1">Verified</option>
                                        <option value="0">Not Verified</option>
                                    </x-select-input>
                                </div>
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label class="uppercase" for="password" :value="__('Password')" />
                                <x-text-input id="password" name="password" type="password" autocomplete="new-password" placeholder="••••••••" />
                                <p class="text-muted-foreground mt-2 text-[10px] font-medium" id="passwordHelpBlock">
                                    Minimum 8 characters</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="border-foreground/20 flex items-center justify-end gap-x-3 border-t px-6 py-4">
                    <x-button-light data-hs-overlay="#user-modal" type="button">
                        Cancel
                    </x-button-light>
                    <x-button-primary id="saveBtn" type="submit" class="rounded-xl font-semibold px-6 py-2.5 shadow-md">
                        Save Changes
                    </x-button-primary>
                </div>
            </div>
        </div>
    </div>

    <!-- Batch Import Modal -->
    <div id="import-modal"
        class="hs-overlay pointer-events-none fixed start-0 top-0 z-100 hidden size-full overflow-y-auto overflow-x-hidden transition-all hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500">
        <div class="m-3 transition-all hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 sm:mx-auto sm:w-full sm:max-w-4xl">
            <div class="pointer-events-auto flex flex-col rounded-2xl border border-border bg-background shadow-xl">
                <div class="flex items-center justify-between border-b border-border px-6 py-4">
                    <h3 class="text-xl font-bold text-foreground">
                        Batch Import Users
                    </h3>
                    <button type="button" class="inline-flex size-8 items-center justify-center rounded-full border border-transparent text-muted-foreground hover:bg-muted focus:outline-hidden"
                        data-hs-overlay="#import-modal">
                        <span class="sr-only">Close</span>
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>
                <div class="p-6">
                    <!-- Step 1: Upload -->
                    <div id="import-step-upload">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-foreground">Step 1: Upload File</h4>
                                <p class="text-muted-foreground text-sm">Upload your CSV file based on the template.</p>
                            </div>
                            <a href="{{ route('admin.users.template') }}" class="flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
                                <i class="ri-download-cloud-2-line"></i>
                                Download Template
                            </a>
                        </div>

                        <div
                            class="group relative flex h-48 w-full cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-border bg-muted/20 transition-all hover:bg-muted/30">
                            <input type="file" id="import-file-input" accept=".csv" class="absolute inset-0 z-50 h-full w-full cursor-pointer opacity-0" />
                            <div class="flex flex-col items-center justify-center gap-2">
                                <div class="flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary transition-transform group-hover:scale-110">
                                    <i class="ri-file-upload-line text-2xl"></i>
                                </div>
                                <div class="text-center">
                                    <p class="font-semibold text-foreground">Click to upload or drag and drop</p>
                                    <p class="text-muted-foreground text-xs">CSV file only (max. 2MB)</p>
                                </div>
                                <p id="selected-file-name" class="mt-2 hidden text-sm font-medium text-primary italic">
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <x-button-primary id="btn-import-next" disabled class="opacity-50">
                                Next: Preview Data
                                <i class="ri-arrow-right-line ml-1"></i>
                            </x-button-primary>
                        </div>
                    </div>

                    <!-- Step 2: Preview -->
                    <div id="import-step-preview" class="hidden">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-foreground">Step 2: Preview Data</h4>
                                <p class="text-muted-foreground text-sm" id="import-summary-text">Verifying data...</p>
                            </div>
                            <button id="btn-import-back" class="text-sm font-semibold text-muted-foreground hover:text-foreground transition-colors">
                                <i class="ri-arrow-left-line"></i>
                                Back to Upload
                            </button>
                        </div>

                        <div class="max-h-[400px] overflow-auto rounded-xl border border-border">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-muted sticky top-0 z-10">
                                    <tr>
                                        <th class="px-4 py-2 font-bold uppercase text-[11px]">Name</th>
                                        <th class="px-4 py-2 font-bold uppercase text-[11px]">Username</th>
                                        <th class="px-4 py-2 font-bold uppercase text-[11px]">Email</th>
                                        <th class="px-4 py-2 font-bold uppercase text-[11px]">Role</th>
                                        <th class="px-4 py-2 font-bold uppercase text-[11px]">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="import-preview-body">
                                    <!-- Dynamic rows -->
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex items-center justify-between">
                            <p class="text-xs text-muted-foreground italic">Only valid rows will be imported.</p>
                            <x-button-primary id="btn-import-confirm">
                                Confirm & Import Users
                            </x-button-primary>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.dependencies._datatables')

    @push('javascript')
        <script>
            $(document).ready(function() {
                let urlParams = new URLSearchParams(window.location.search);
                let pageParam = parseInt(urlParams.get('page')) || 1;
                let limitParam = parseInt(urlParams.get('limit')) || 10;
                let searchParam = urlParams.get('search') || "";

                if (searchParam) {
                    $('#clear-search').removeClass('hidden');
                }

                let table = new DataTable('#myTable', {
                    responsive: false,
                    scrollX: true,
                    processing: false,
                    serverSide: true,
                    dom: 'lrtip',
                    lengthMenu: [
                        [10, 15, 25, 50, -1],
                        [10, 15, 25, 50, "All"]
                    ],
                    displayStart: (pageParam - 1) * limitParam,
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
                    search: {
                        search: urlParams.get('search') || ""
                    },
                    order: [
                        [1, 'asc']
                    ],
                    columns: [{
                            data: 'checkbox',
                            name: 'checkbox',
                            orderable: false,
                            searchable: false,
                            className: 'px-2 py-2 text-center w-10'
                        },
                        {
                            data: 'user_info',
                            name: 'user_info',
                            className: 'px-4 py-2'
                        },
                        {
                            data: 'username',
                            name: 'username',
                            className: 'px-4 py-2'
                        },
                        {
                            data: 'role',
                            name: 'role',
                            className: 'px-4 py-2',
                            render: function(data) {
                                const colors = {
                                    'admin': 'bg-primary/10 text-primary border-primary/20',
                                    'user': 'bg-success/10 text-success border-success/20',
                                };
                                const colorClass = colors[data] || 'bg-muted text-muted-foreground border-border';
                                return `<span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-medium ${colorClass}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            className: 'px-4 py-2',
                            render: function(data) {
                                if (!data) return '-';
                                const date = new Date(data);
                                return date.toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'short',
                                    day: 'numeric'
                                });
                            }
                        },
                        {
                            data: 'verified',
                            name: 'verified',
                            searchable: false,
                            className: 'px-4 py-2 text-center',
                            render: function(data) {
                                const isVerified = data !== null;
                                const colorClass = isVerified
                                    ? 'bg-success/10 text-success border-success/20'
                                    : 'bg-warning/10 text-warning border-warning/20';
                                const icon = isVerified ? 'ri-shield-check-line' : 'ri-shield-cross-line';
                                const text = isVerified ? 'Verified' : 'Unverified';
                                return `<span class="inline-flex items-center gap-1 rounded-full border px-2.5 py-0.5 text-xs font-medium ${colorClass}"><i class="${icon}"></i>${text}</span>`;
                            }
                        },
                        {
                            data: 'social_login',
                            name: 'social_login',
                            orderable: false,
                            searchable: false,
                            className: 'px-4 py-2 text-center',
                            render: function(data) {
                                if (!data) {
                                    return `<span class="text-muted-foreground text-xs">—</span>`;
                                }
                                const icons = {
                                    'google': 'ri-google-fill',
                                    'github': 'ri-github-fill',
                                    'facebook': 'ri-facebook-fill',
                                    'twitter': 'ri-twitter-x-fill',
                                };
                                const icon = icons[data.toLowerCase()] || 'ri-links-line';
                                const label = data.charAt(0).toUpperCase() + data.slice(1);
                                return `<span class="inline-flex items-center gap-1 rounded-full border border-border bg-muted px-2.5 py-0.5 text-xs font-medium text-foreground"><i class="${icon}"></i>${label}</span>`;
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'px-4 py-2'
                        },
                    ],
                    language: {
                        emptyTable: `<div class="py-16 text-center w-full"><i class="ri-user-search-line text-6xl text-muted-foreground/20"></i><p class="mt-4 text-muted-foreground text-lg font-medium">No users found in the system</p></div>`,
                        zeroRecords: `<div class="py-16 text-center w-full"><i class="ri-search-eye-line text-6xl text-muted-foreground/20"></i><p class="mt-4 text-muted-foreground text-lg font-medium">No matching records found for your search</p></div>`,
                        infoEmpty: "",
                        infoFiltered: ""
                    }
                });

                // Sync URL and reset selections on DataTables draw
                table.on('draw.dt', function() {
                    let info = table.page.info();
                    let newUrl = new URL(window.location);
                    newUrl.searchParams.set('page', info.page + 1);
                    newUrl.searchParams.set('limit', info.length);
                    window.history.replaceState({}, '', newUrl);

                    $('#check-all').prop('checked', false);
                    toggleBatchDeleteBtn();
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

                // Custom Search
                let searchTimeout = null;
                $('#custom-search').on('keyup', function(e) {
                    const value = this.value;

                    if (e.key === 'Escape') {
                        $(this).val('');
                        $('#clear-search').addClass('hidden');
                        table.search('').draw();
                        let newUrl = new URL(window.location);
                        newUrl.searchParams.delete('search');
                        window.history.replaceState({}, '', newUrl);
                        return;
                    }

                    if (value) {
                        $('#clear-search').removeClass('hidden');
                    } else {
                        $('#clear-search').addClass('hidden');
                    }

                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        table.search(value).draw();

                        // Update search param in URL
                        let newUrl = new URL(window.location);
                        if (value) {
                            newUrl.searchParams.set('search', value);
                        } else {
                            newUrl.searchParams.delete('search');
                        }
                        window.history.replaceState({}, '', newUrl);
                    }, 500);
                });

                // Clear Search
                $('#clear-search').on('click', function() {
                    $('#custom-search').val('');
                    $('#clear-search').addClass('hidden');
                    table.search('').draw();

                    let newUrl = new URL(window.location);
                    newUrl.searchParams.delete('search');
                    window.history.replaceState({}, '', newUrl);
                });

                // Role Filter
                $('.role-filter-item').on('click', function() {
                    let role = $(this).data('role');
                    let newUrl = new URL(window.location);

                    if (role) {
                        newUrl.searchParams.set('role', role);
                    } else {
                        newUrl.searchParams.delete('role');
                    }

                    // Reset to first page when filter changes
                    newUrl.searchParams.set('page', 1);
                    window.history.replaceState({}, '', newUrl);

                    // Update UI active state
                    $('.role-filter-item').removeClass('bg-primary/10 text-primary font-medium');
                    $(this).addClass('bg-primary/10 text-primary font-medium');

                    // Reload table with new URL
                    table.ajax.url(newUrl.toString()).load();
                });

                // Export Users
                $('#export-users').on('click', function() {
                    let exportUrl = new URL("{{ route('admin.users.export') }}");
                    let currentUrl = new URL(window.location);

                    if (currentUrl.searchParams.has('search')) {
                        exportUrl.searchParams.set('search', currentUrl.searchParams.get('search'));
                    }
                    if (currentUrl.searchParams.has('role')) {
                        exportUrl.searchParams.set('role', currentUrl.searchParams.get('role'));
                    }

                    window.location.href = exportUrl.toString();
                });

                // Checkbox Logic
                $('#check-all').on('change', function() {
                    $('.user-checkbox').prop('checked', this.checked);
                    toggleBatchDeleteBtn();
                });

                $(document).on('change', '.user-checkbox', function() {
                    let allChecked = $('.user-checkbox:checked').length === $('.user-checkbox').length;
                    $('#check-all').prop('checked', allChecked);
                    toggleBatchDeleteBtn();
                });

                function toggleBatchDeleteBtn() {
                    let checkedCount = $('.user-checkbox:checked').length;
                    if (checkedCount > 0) {
                        $('#batch-delete-btn').removeClass('hidden').find('span').text(`Delete Selected (${checkedCount})`);
                    } else {
                        $('#batch-delete-btn').addClass('hidden');
                    }
                }

                // Batch Delete Action
                $('#batch-delete-btn').on('click', function() {
                    let ids = $('.user-checkbox:checked').map(function() {
                        return $(this).val();
                    }).get();

                    ZkPopAlert.show({
                        message: `Are you sure you want to delete ${ids.length} selected users?`,
                        confirmText: "Yes, delete them",
                        cancelText: "No, cancel",
                        onConfirm: () => {
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('admin.users.batch-destroy') }}",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    ids: ids
                                },
                                success: function(response) {
                                    table.ajax.reload(null, false);
                                    MyZkToast.success(response.message);
                                },
                                error: function(error) {
                                    MyZkToast.error(error.responseJSON.message || "An error occurred");
                                }
                            });
                        }
                    });
                });

                $('#create-new-user').click(function() {
                    $(".modal-loader-data").hide()
                    $("#userForm").show();
                    $('#user-modal').find('.modal-title').text('Add New User');
                    $('#userForm').attr('method', 'POST');
                    $('#_method').val('POST');
                    $('#userForm').trigger("reset");
                    $('#userForm').attr('action', '{{ route('admin.users.store') }}');
                    $('#saveBtn').text('Create User');
                    $("#error-messages").html("");
                    $("#passwordHelpBlock").text("Minimum 8 characters");

                    $('#email').prop('disabled', false).removeClass('bg-gray-100');
                    $('#password').prop('disabled', false).removeClass('bg-gray-100');
                    $('#social-login-note').remove();
                    $('#username').prop('readonly', false).removeClass('bg-gray-100');
                    $('#usernameHelpBlock').addClass('hidden');
                });

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
                            $('#saveBtn').prop('disabled', true).addClass('opacity-50');
                        },
                        success: function(response) {
                            closeModal('#user-modal');
                            table.ajax.reload(null, false);
                            MyZkToast.success(response.message);
                        },
                        error: function(error) {
                            displayErrors(error.responseJSON.errors);
                        },
                        complete: function() {
                            $('#saveBtn').prop('disabled', false).removeClass('opacity-50');
                        }
                    });
                });

                $('body').on('click', '.edit-user', function() {
                    $('#userForm').trigger("reset");
                    $(".modal-loader-data").show();
                    $("#userForm").hide();
                    $('#saveBtn').prop('disabled', true);
                    $('#user-modal').find('.modal-title').text('Edit User');
                    $("#error-messages").html("");
                    $("#passwordHelpBlock").text("Leave blank if you don't want to change");
                    $('#usernameHelpBlock').addClass('hidden');
                    const userId = $(this).data('id');

                    let newUrl = new URL(window.location);
                    newUrl.searchParams.set('user_id', userId);
                    window.history.pushState({}, '', newUrl);

                    openModal('#user-modal');
                    getUserData(userId);
                });

                $('body').on('click', '.delete-user', function(e) {
                    e.preventDefault();
                    const userId = $(this).data('id');

                    ZkPopAlert.show({
                        message: "Are you sure you want to delete this user?",
                        confirmText: "Yes, delete it",
                        cancelText: "No, cancel",
                        onConfirm: () => {
                            $.ajax({
                                type: "DELETE",
                                url: `{{ route('admin.users.destroy', ':userId') }}`.replace(':userId', userId),
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    table.ajax.reload(null, false);
                                    MyZkToast.success(response.message);
                                },
                                error: function(error) {
                                    MyZkToast.error(error.responseJSON.message || "An error occurred");
                                }
                            });
                        }
                    });
                });

                function getUserData(userId) {
                    $.get(`{{ route('admin.users.show', ':userId') }}`.replace(':userId', userId))
                        .done(function(data) {
                            $(".modal-loader-data").hide();
                            $("#userForm").show();
                            $('#saveBtn').prop('disabled', false);
                            $('#userForm').attr('action', `{{ route('admin.users.update', ':userId') }}`.replace(':userId', userId));
                            $('#saveBtn').text('Update User');
                            $('#_method').val('PUT');
                            $('#name').val(data.name);
                            $('#username').val(data.username);
                            $('#role').val(data.role);
                            $('#email').val(data.email);
                            $('#email_verified_at').val(data.email_verified_at ? 1 : 0);

                            // Disable username for admin/superadmin
                            if (data.username === 'admin') {
                                $('#username').prop('readonly', true).addClass('bg-gray-100');
                                $('#usernameHelpBlock').text("{{ __('messages.username_change_error') }}").removeClass('hidden');
                            } else {
                                $('#username').prop('readonly', false).removeClass('bg-gray-100');
                                $('#usernameHelpBlock').addClass('hidden');
                            }

                            if (data.provider_name) {
                                $('#email').prop('disabled', true).addClass('bg-gray-100');
                                $('#password').prop('disabled', true).addClass('bg-gray-100');
                                if ($('#social-login-note').length === 0) {
                                    $('#password').after('<p id="social-login-note" class="text-error mt-2 text-[10px] font-medium">Fields disabled for social login users</p>');
                                }
                            } else {
                                $('#email').prop('disabled', false).removeClass('bg-gray-100');
                                $('#password').prop('disabled', false).removeClass('bg-gray-100');
                                $('#social-login-note').remove();
                            }
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            displayErrors({
                                general: [`${textStatus}: ${errorThrown}`]
                            });
                            $(".modal-loader-data").hide();
                            $('#saveBtn').prop('disabled', true);
                        });
                }

                function displayErrors(errors = {}) {
                    let errorHtml = '<div class="mb-4 rounded-xl bg-error/10 p-4 text-sm text-error border border-error/20">';
                    Object.values(errors).forEach((message) => {
                        errorHtml += `<div class="flex items-center gap-2"><i class="ri-error-warning-line"></i> <span>${message[0]}</span></div>`;
                    });
                    errorHtml += '</div>';
                    $('#error-messages').html(errorHtml);
                }

                // Handle direct URL opening
                if (urlParams.has("user_id")) {
                    let userId = urlParams.get("user_id");
                    $(".modal-loader-data").show();
                    $("#userForm").hide();
                    $('#user-modal').find('.modal-title').text('Edit User');
                    setTimeout(() => openModal('#user-modal'), 500);
                    getUserData(userId);
                }

                // Batch Import Logic
                let importedUsers = [];

                $('#import-file-input').on('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        $('#selected-file-name').text(file.name).removeClass('hidden');
                        $('#btn-import-next').prop('disabled', false).removeClass('opacity-50');
                    } else {
                        $('#selected-file-name').addClass('hidden');
                        $('#btn-import-next').prop('disabled', true).addClass('opacity-50');
                    }
                });

                $('#btn-import-next').on('click', function() {
                    const fileInput = $('#import-file-input')[0];
                    if (fileInput.files.length === 0) return;

                    const formData = new FormData();
                    formData.append('file', fileInput.files[0]);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: "{{ route('admin.users.import-preview') }}",
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('#btn-import-next').prop('disabled', true).html('<i class="ri-loader-4-line animate-spin mr-2"></i> Verifying...');
                        },
                        success: function(response) {
                            importedUsers = response.rows.filter(r => r.is_valid).map(r => r.data);

                            // Update summary
                            $('#import-summary-text').text(`Total: ${response.summary.total} rows | Valid: ${response.summary.valid} | Invalid: ${response.summary.invalid}`);

                            // Update table
                            let rowsHtml = '';
                            response.rows.forEach(row => {
                                const statusClass = row.is_valid ? 'text-success bg-success/10' : 'text-error bg-error/10';
                                const statusText = row.is_valid ? 'Valid' : 'Invalid';
                                const errorList = row.errors.length > 0 ? `<div class="text-[10px] text-error mt-1">${row.errors.join(', ')}</div>` : '';

                                rowsHtml += `
                                    <tr class="border-b border-border/50 hover:bg-muted/30 transition-colors">
                                        <td class="px-2 py-1 font-medium text-foreground">${row.data.name}</td>
                                        <td class="px-2 py-1 text-muted-foreground">${row.data.username}</td>
                                        <td class="px-2 py-1 text-muted-foreground">${row.data.email}</td>
                                        <td class="px-2 py-1 text-muted-foreground">${row.data.role}</td>
                                        <td class="px-2 py-1">
                                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold uppercase ${statusClass}">
                                                ${statusText}
                                            </span>
                                            ${errorList}
                                        </td>
                                    </tr>
                                `;
                            });
                            $('#import-preview-body').html(rowsHtml);

                            // Switch view
                            $('#import-step-upload').addClass('hidden');
                            $('#import-step-preview').removeClass('hidden');

                            // Enable/Disable confirm button
                            $('#btn-import-confirm').prop('disabled', importedUsers.length === 0);
                        },
                        error: function(xhr) {
                            MyZkToast.error(xhr.responseJSON?.message || 'Error parsing file');
                        },
                        complete: function() {
                            $('#btn-import-next').prop('disabled', false).html('Next: Preview Data <i class="ri-arrow-right-line ml-1"></i>');
                        }
                    });
                });

                $('#btn-import-back').on('click', function() {
                    $('#import-step-preview').addClass('hidden');
                    $('#import-step-upload').removeClass('hidden');
                });

                $('#btn-import-confirm').on('click', function() {
                    if (importedUsers.length === 0) return;

                    $.ajax({
                        url: "{{ route('admin.users.import-confirm') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            users: importedUsers
                        },
                        beforeSend: function() {
                            $('#btn-import-confirm').prop('disabled', true).html('<i class="ri-loader-4-line animate-spin mr-2"></i> Importing...');
                        },
                        success: function(response) {
                            closeModal('#import-modal');
                            table.ajax.reload(null, false);
                            MyZkToast.success(response.message);

                            // Reset modal for next time
                            resetImportModal();
                        },
                        error: function(xhr) {
                            MyZkToast.error(xhr.responseJSON?.message || 'Import failed');
                        },
                        complete: function() {
                            $('#btn-import-confirm').prop('disabled', false).text('Confirm & Import Users');
                        }
                    });
                });

                function resetImportModal() {
                    $('#import-file-input').val('');
                    $('#selected-file-name').addClass('hidden');
                    $('#btn-import-next').prop('disabled', true).addClass('opacity-50');
                    $('#import-step-preview').addClass('hidden');
                    $('#import-step-upload').removeClass('hidden');
                    $('#import-preview-body').empty();
                    importedUsers = [];
                }

                // Reset modal on close
                $(document).on('hs-overlay-close', '#import-modal', function() {
                    resetImportModal();
                });
            });
        </script>
    @endpush
</x-app-layout>
