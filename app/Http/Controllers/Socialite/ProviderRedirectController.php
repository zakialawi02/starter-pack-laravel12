<?php

namespace App\Http\Controllers\Socialite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class ProviderRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $provider)
    {
        if (!config("services.{$provider}")) {
            return redirect()->route('login')->withErrors(['provider' => 'Invalid provider']);
        }

        try {
            // Store the redirect URL in session if it exists
            if ($request->has('redirect')) {
                session(['oauth_redirect' => $request->get('redirect')]);
            }

            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['provider' => 'Something went wrong']);
        }
    }
}
