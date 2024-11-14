<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Illuminate\Support\Facades\View;

class ShareNotifications
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        return $next($request);
    }
}
