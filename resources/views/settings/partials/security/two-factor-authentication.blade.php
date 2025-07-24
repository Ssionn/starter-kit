<div
    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden p-4">
    <div class="flex items-center space-x-2">
        <span class="text-xl font-semibold">{{ __('Two factor authentication') }}</span>
        @if (auth()->user()->google2fa_enabled)
            <span class="text-sm font-semibold bg-emerald-400 dark:bg-emerald-800 px-4 py-1 rounded-md">
                {{ __('Activated') }}
            </span>
        @else
            <span class="text-sm font-semibold bg-red-400 dark:bg-red-800 px-2 py-1 rounded-md">
                {{ __('Not activated') }}
            </span>
        @endif
    </div>
    @if (!auth()->user()->google2fa_enabled)
        <div x-data="twoFa()" x-init="() => {}">
            <x-button x-show="!showQr && !success" @click="generate()">{{ __('Enable one-time-password') }}</x-button>

            <template x-if="showQr">
                <div class="mt-4">
                    <img :src="qrCode" alt="QR Code" class="mb-4">
                    <form @submit.prevent="verify()">
                        <input x-model="otp" type="text" placeholder="123456" class="border p-2 mr-2">
                        <button class="px-3 py-2 bg-green-600 text-white">
                            Verify
                        </button>
                    </form>
                    <p x-text="error" class="text-red-600 mt-2"></p>
                </div>
            </template>
        </div>
    @else
    @endif
</div>
