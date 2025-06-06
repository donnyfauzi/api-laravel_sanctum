<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckTokenExpiry
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->user()?->currentAccessToken();

        if ($token && $token->expires_at && $token->expires_at->isPast()) {
            $token->delete(); // hapus token yang sudah expired
            return response()->json([
                'message' => 'Token expired. Silakan login kembali.'
            ], 401);
        }

        return $next($request);
    }
}
