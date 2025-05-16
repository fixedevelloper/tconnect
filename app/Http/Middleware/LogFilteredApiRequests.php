<?php
namespace App\Http\Middleware;

use App\Models\ApiLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LogFilteredApiRequests
{
    public function handle(Request $request, Closure $next)
    {
        // Seulement pour les URLs qui commencent par /api/
        if ($request->is('api/transactions/*') || $request->is('api/create/*')) {

            $startTime = microtime(true);

            $response = $next($request);

            $endTime = microtime(true);
            $duration = number_format(($endTime - $startTime) * 1000, 2);

            ApiLog::create([
                'method'          => $request->method(),
                'url'             => $request->fullUrl(),
                'ip'              => $request->ip(),
                'headers'         => $request->headers->all(),
                'request_body'    => $request->all(),
                'response_status' => $response->status(),
                'response_body'   => method_exists($response, 'getContent') ? json_decode($response->getContent(), true) : null,
                'duration_ms'     => $duration,
                'customer_id'     => Session::get('customer_id'),
            ]);

            return $response;
        }

        // Si ce n'est pas /api/*, juste passer la requête normalement
        return $next($request);
    }
}
