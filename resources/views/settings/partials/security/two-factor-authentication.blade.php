<div
    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-4">
    <div class="flex items-center space-x-2">
        <span class="text-xl font-semibold">{{ __('Two factor authentication') }}</span>
        @if (auth()->user()->google2fa_enabled)
            <span class="text-sm font-semibold bg-emerald-400 dark:bg-emerald-800 px-4 py-0.5 rounded-md">
                {{ __('Activated') }}
            </span>
        @else
            <span class="text-sm font-semibold bg-red-400 dark:bg-red-800 px-2 py-0.5 rounded-md">
                {{ __('Not activated') }}
            </span>
        @endif
    </div>
    @if (!auth()->user()->google2fa_enabled)
        <div x-data="twoFa()" x-init="() => {}">
            <x-button class="mt-4" x-show="!showQr && !success"
                @click="generate()">{{ __('Enable one-time-password') }}</x-button>

            <template x-if="showQr" class="w-full">
                <div class="flex flex-col items-center sm:flex-row mt-4 w-full">
                    <img :src="qrCode" alt="QR Code" class="w-32 h-32">
                    <div class="ml-0 sm:ml-4 mt-2 sm:mt-0">
                        <form @submit.prevent="verify()">
                            <x-forms.input label="Verify" name="otp" x-model="otp" placeholder="123456"
                                class="border p-2 mr-2" />
                        </form>
                        <p x-text="error" class="text-red-600 mt-2">{{ __('Please fill in the correct otp code') }}</p>
                    </div>
                </div>
            </template>
        </div>
    @else
    @endif
</div>
