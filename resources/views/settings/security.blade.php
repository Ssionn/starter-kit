<x-layouts.app>
    <!-- Breadcrumbs -->
    <div class="mb-6 flex items-center text-sm">
        <a href="{{ route('dashboard') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Dashboard') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ route('settings.profile.edit') }}"
            class="text-blue-600 dark:text-blue-400 hover:underline">{{ __('Profile') }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-2 text-gray-400" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ __('Security') }}</span>
    </div>

    <!-- Page Title -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Security') }}</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">
            {{ __('Ensure your account is safe at all times') }}
        </p>
    </div>

    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar Navigation -->
            @include('settings.partials.navigation')

            <!-- Security Content -->
            <div class="flex-1 space-y-3">
                <div>
                    @include('settings.partials.security.change-password')
                </div>
                <div>
                    @include('settings.partials.security.two-factor-authentication')
                </div>
            </div>
        </div>
    </div>


    <script>
        function twoFa() {
            return {
                showQr: false,
                qrCode: null,
                otp: '',
                error: '',
                success: false,

                async generate() {
                    this.error = '';
                    let res = await fetch('{{ route('2fa.qr') }}');
                    let data = await res.json();
                    this.qrCode = data.qrCode;
                    this.showQr = true;
                },

                async verify() {
                    this.error = '';
                    let response = await fetch('{{ route('2fa.enable') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            otp: this.otp
                        })
                    });

                    if (!response.ok) {
                        let err = await response.json();
                        this.error = err.error || 'Verification failed';
                        return;
                    }

                    this.success = true;
                    this.showQr = false;
                }
            };
        }
    </script>
</x-layouts.app>
