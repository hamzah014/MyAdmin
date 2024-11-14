<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AuthorizeSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token = $request->bearerToken();

        $user = User::where('remember_token', $token)->first();

        if (empty($user))
            return response()->json([
                'error' => 1,
                'message' => 'Invalid API key.',
            ], 401);


        if($user->role->id !== 1)
        {
            return response()->json([
                'error' => 1,
                'message' => 'You dont have any access to this function.'
            ], 401);
        }

        return $next($request);
    }
}
