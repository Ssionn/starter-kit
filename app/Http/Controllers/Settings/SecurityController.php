<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use PragmaRX\Google2FALaravel\Facade as Google2FA;

class SecurityController extends Controller
{
    public function edit(Request $request): View
    {
        return view('settings.security', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function generateQr(): JsonResponse
    {
        $secret = Google2FA::generateSecretKey();

        auth()->user()->update([
            'google2fa_secret' => $secret
        ]);

        $svg = Google2FA::getQRCodeInline(
            config('app.name'),
            auth()->user()->email,
            $secret
        );

        $dataUri = 'data:image/svg+xml;base64,' . base64_encode($svg);

        return response()->json(['qrCode' => $dataUri]);
    }

    public function enable2fa(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $secret = auth()->user()->google2fa_secret;

        if (! Google2FA::verifyKey($secret, $request->otp)) {
          return response()->json(['error' => 'Invalid code'], 422);
        }

        auth()->user()->update([
            'google2fa_enabled' => true
        ]);

        return back()->with('status', 'OTP has been enabled');
  }
}
