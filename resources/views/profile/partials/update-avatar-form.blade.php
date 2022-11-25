<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('profileData.avatar_update') }}
        </h2>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <img src="{{Auth::user()->icon_path}}" alt="Аватар пользователя">
        </div>

        <div>
            <x-input-label for="avatar_file" :value="__('profileData.avatar')" />
            <x-file-input type="file" id="formFile" name="avatar" accept="image/jpeg, image/png" required />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profileData.save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('profileData.saved') }}</p>
            @endif
        </div>
    </form>
</section>
