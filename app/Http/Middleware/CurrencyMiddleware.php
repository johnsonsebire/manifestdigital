<?php

namespace App\Http\Middleware;

use App\Services\CurrencyService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrencyMiddleware
{
    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Detect and set user currency on first visit
        if (!session()->has('currency_code')) {
            $currency = $this->currencyService->detectUserCurrency($request->ip());
            session(['currency_code' => $currency->code]);
        }

        // Handle currency switching via query parameter
        if ($request->has('currency')) {
            $currencyCode = strtoupper($request->get('currency'));
            if ($this->currencyService->setUserCurrency($currencyCode)) {
                // Redirect to remove the currency parameter from URL
                return redirect($request->url());
            }
        }

        return $next($request);
    }
}
