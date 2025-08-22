<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Handle the incoming logout request.
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            $currentToken = $user->currentAccessToken();
            $bearerToken = $request->bearerToken();

            $token = null;

            // Try to find the correct token from the Authorization header
            if ($bearerToken) {
                $tokenId = explode('|', $bearerToken, 2)[0] ?? null;
                if ($tokenId && is_numeric($tokenId)) {
                    $token = $user->tokens()->where('id', $tokenId)->first();
                }
            }

            // Fallback to currentAccessToken() if manual parsing fails and it's not a TransientToken
            if (!$token && $currentToken && !($currentToken instanceof \Laravel\Sanctum\TransientToken)) {
                $token = $currentToken;
            }

            // Only delete if it's a real database token, not a TransientToken
            if ($token && !($token instanceof \Laravel\Sanctum\TransientToken)) {
                $token->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Logged out'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to logout: ' . $e->getMessage()
            ], 500);
        }
    }
}
