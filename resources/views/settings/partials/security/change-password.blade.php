<div
    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-4">
    <span class="text-xl font-semibold">{{ __('Change password') }}</span>
    <div>
        <!-- Change password form -->
        <form class="max-w-md space-y-3 mt-4" action="{{ route('settings.security.password.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <x-forms.input label="Current Password" name="current_password" type="password" />
            </div>

            <div>
                <x-forms.input label="New Password" name="password" type="password" />
            </div>

            <div>
                <x-forms.input label="Confirm Password" name="password_confirmation" type="password" />
            </div>

            <div class="mt-4">
                <x-button type="primary">{{ __('Update Password') }}</x-button>
            </div>
        </form>
    </div>
</div>
