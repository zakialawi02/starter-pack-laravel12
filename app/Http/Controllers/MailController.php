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

        for ($i = 0; $i < 5; $i++) {
            SendUserMail::dispatch($user->email, $user->name);
        }

        return response()->json([
            'message' => '5 queued emails are being sent.',
            'user' => [
                'username' => $user->username,
                'email' => $user->email,
            ],
            'queued_jobs' => 5,
        ], 202);
    }
}
