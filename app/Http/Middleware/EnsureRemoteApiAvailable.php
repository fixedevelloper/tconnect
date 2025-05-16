<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\RemoteApiService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRemoteApiAvailable
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && (Auth::user()->user_type == User::CUSTOMER_TYPE)) {
            return $next($request);
        }
        notify()->error('Access forbidden','WTC session abort');
        return  redirect()->route('secure.login');

    }
}
