<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\RemoteApiService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRemoteSandboxApiAvailable
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && (Auth::user()->user_type == User::CUSTOMER_TYPE)) {
            return $next($request);
        }
        notify()->error('Access forbidden','WTC session abort');
        return  redirect()->route('sandbox.login');


    }
}
