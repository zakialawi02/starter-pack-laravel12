<section class="mb-10">
    <header>
        <h2 class="text-base-content text-lg font-medium">
            {{ __('Profile Photo') }}
        </h2>

        <p class="text-base-content-muted mt-1 text-sm">
            {{ __("Update your account's photo profile.") }}
        </p>
    </header>

    <form class="mt-6 space-y-6" method="post" action="{{ route('admin.profile.photo-update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex flex-col items-center space-y-5 sm:flex-row sm:space-y-0">
            <!-- Display the current photo profile here -->
            <img class="h-30 w-30 ring-primary rounded-full object-cover p-1 ring-2" id="current-photo" src={{ Auth::user()->profile_photo_path }} alt="Current Photo Profile" onerror="this.src='https://placehold.co/100x100'">

            <div class="flex flex-col space-y-5 sm:ml-8">
                <input class="hidden" id="photo_profile" name="photo_profile" type="file" accept="image/*">
                <x-button-primary type="button" :size="'small'" onclick="document.getElementById('photo_profile').click()">
                    Change picture
                </x-button-primary>
                <x-button-secondary id="delete_photo" type="button" disabled :size="'small'">
                    Delete picture
                </x-button-secondary>
            </div>

        </div>

        <p class="text-red-500" id="error_message"></p>
        @error('photo_profile')
            <span class="text-red-500" role="alert">
                {{ $message }}
            </span>
        @enderror

        <div class="mt-4 flex items-center gap-4">
            <x-button-primary>{{ __('Save') }}</x-button-primary>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<section>
    <header>
        <h2 class="text-base-content text-lg font-medium">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-base-content-muted mt-1 text-sm">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form class="mt-6 space-y-6" method="post" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input class="mt-1 block w-full" id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button class="focus:outline-hidden rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" form="send-verification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-button-primary type="submit">{{ __('Save') }}</x-button-primary>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

@push('javascript')
    <script>
        let inputPhoto;
        document.getElementById('photo_profile').addEventListener('change', function(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const preview = document.getElementById('current-photo');
            const errorMsg = document.getElementById('error_message');

            if (!preview.dataset.originalSrc) {
                preview.dataset.originalSrc = preview.src;
                inputPhoto = false;
            }

            if (file) {
                if (file.size > 1024 * 1024) {
                    errorMsg.textContent = 'File size must be less than 1MB';
                    preview.src = preview.dataset.originalSrc;
                    fileInput.value = '';
                    inputPhoto = false;
                } else {
                    errorMsg.textContent = '';
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    inputPhoto = true;
                    document.getElementById('delete_photo').disabled = false;
                    reader.readAsDataURL(file);
                }
            }
        });

        document.getElementById('delete_photo').addEventListener('click', function() {
            if (!inputPhoto) {
                return
            }
            const fileInput = document.getElementById('photo_profile');
            const preview = document.getElementById('current-photo');
            const errorMsg = document.getElementById('error_message');

            fileInput.value = '';
            preview.src = preview.dataset.originalSrc;
            errorMsg.textContent = '';
            inputPhoto = false;
            document.getElementById('delete_photo').disabled = true;
        });
    </script>
@endpush
