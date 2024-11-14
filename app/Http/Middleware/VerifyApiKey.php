<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {

        $token = $request->bearerToken();

        $user = User::where('remember_token', $token)->first();

        if (empty($user))
            return response()->json([
                'error' => 1,
                'message' => 'Invalid API key.',
            ], 401);

        Auth::login($user);

        return $next($request);
    }
}
