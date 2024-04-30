<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAntiPhishingKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = $request->query('key');
        $chave = $request->query('chave');
        
        if(!$key && $chave){
            $key = $chave;
        }

        if ($key != 'kZyfnUto?d&P@C-I&OyS%J0IZf3Cmyn') {
            return response('Chave anti-phishing inválida', 403);
        }

        return $next($request);
    }
}
