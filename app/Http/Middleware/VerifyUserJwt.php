<?php

namespace App\Http\Middleware;

use App\Helpers\api\Helpers;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use Illuminate\Support\Facades\Session;

class VerifyUserJwt
{
    public function handle(Request $request, Closure $next)
    {
        $privateKey = file_get_contents('private.pem');
        $publicKey = file_get_contents('public.pem');
        $authHeader = $request->header('Authorization');
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return Helpers::unauthorized('Token not provided');
        }

        $token = trim(str_replace('Bearer', '', $authHeader));
        try {
            // Décodage non vérifié pour extraire customer_id
            $payload = json_decode(base64_decode(explode('.', $token)[1]), true);
            $userId = $payload['sub'] ?? null;

            if (!$userId) {
                throw new Exception('Invalid token payload');
            }

            $user = User::find($userId);

            if (! $user || ! $publicKey) {
                throw new Exception('User not found or missing public key');
            }
            // Vérification du token avec la clé publique
            $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));

            // Injecter le customer dans la requête
            $request->merge(['personnal' => $user]);

        } catch (Exception $e) {
            logger($e->getMessage());
           // return response()->json(['error' => 'Invalid token: ' . $e->getMessage()], 401);
            return Helpers::unauthorized('Error','Invalid token: ' . $e->getMessage());
        }

        return $next($request);
    }
}
