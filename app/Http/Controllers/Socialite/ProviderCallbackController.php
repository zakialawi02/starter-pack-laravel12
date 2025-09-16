<?php

namespace App\Http\Controllers\Socialite;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderCallbackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $provider)
    {
        if (!config("services.{$provider}")) {
            return redirect()->route('login')->withErrors(['provider' => 'Invalid provider']);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();

            // Generate username from provider or fallback to name/email
            $username = $this->generateUsername($socialUser, $provider);

            $user = User::updateOrCreate([
                'provider_id' => $socialUser->id,
                'provider_name' => $provider,
            ], [
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'email_verified_at' => now(),
                'username' => $username,
                'provider_token' => $socialUser->token,
                'provider_refresh_token' => $socialUser->refreshToken,
            ]);

            Auth::login($user);

            // Check if there's a stored redirect URL from OAuth flow
            $redirectUrl = session()->pull('oauth_redirect');
            if ($redirectUrl && $redirectUrl !== '/') {
                return redirect($redirectUrl);
            }

            return redirect('/dashboard');
        } catch (\Exception $e) {

            return redirect()->route('login')->withErrors(['provider' => 'Unable to login using ' . ucfirst($provider) . '. Please try again.']);
        }
    }

    private function generateUsername($socialUser, $provider)
    {
        // Try to get username from provider
        $username = $socialUser->getNickname() ?? null;

        // If no username from provider, generate from name or email
        if (!$username) {
            if (!empty($socialUser->name)) {
                // Use name and convert to username format
                $username = strtolower(str_replace(' ', '_', $socialUser->name)) . '_' . rand(1000, 9999);
            } else {
                // Use email prefix as fallback
                $username = strtolower(explode('@', $socialUser->email)[0]) . '_' . rand(1000, 9999);
            }
        }

        // Clean username (remove special characters, keep only alphanumeric and underscore)
        $username = preg_replace('/[^a-z0-9_]/', '', strtolower($username));

        // Ensure username is unique
        $baseUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $counter;
            $counter++;
        }

        return $username;
    }
}
