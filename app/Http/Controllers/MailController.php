<?php

namespace App\Http\Controllers;

use App\Jobs\SendUserMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class MailController extends Controller
{
    public function sendToUser(string $username): JsonResponse
    {
        $user = User::where('username', $username)->firstOrFail();

        SendUserMail::dispatch($user->email, $user->name);

        return response()->json([
            'message' => 'Email is being sent via queue.',
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
            ],
        ], 202);
    }
}
