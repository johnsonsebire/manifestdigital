<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogLivewireRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only log Livewire requests and auth-related requests
        if ($this->shouldLog($request)) {
            Log::info('LIVEWIRE_REQUEST_START', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip(),
                'session_id' => session()->getId(),
                'csrf_token' => csrf_token(),
                'headers' => [
                    'x-csrf-token' => $request->header('X-CSRF-TOKEN'),
                    'x-requested-with' => $request->header('X-Requested-With'),
                    'x-livewire' => $request->header('X-Livewire'),
                ],
                'livewire_data' => $request->input('components', []),
                'auth_check' => auth()->check(),
                'auth_user_id' => auth()->id(),
            ]);
        }

        $response = $next($request);

        if ($this->shouldLog($request)) {
            Log::info('LIVEWIRE_REQUEST_END', [
                'url' => $request->fullUrl(),
                'status_code' => $response->getStatusCode(),
                'content_type' => $response->headers->get('Content-Type'),
                'auth_check_after' => auth()->check(),
                'auth_user_id_after' => auth()->id(),
                'session_id_after' => session()->getId(),
            ]);
        }

        return $response;
    }

    private function shouldLog(Request $request): bool
    {
        return $request->is('livewire/*') || 
               $request->is('login') || 
               $request->is('register') || 
               $request->is('debug-*') ||
               str_contains($request->header('X-Livewire', ''), 'true');
    }
}
