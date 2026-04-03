<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected array $supportedLocales = ['sr', 'en', 'ru'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);

        if (in_array($locale, $this->supportedLocales)) {
            app()->setLocale($locale);
        } else {
            app()->setLocale(config('app.locale', 'sr'));
        }

        return $next($request);
    }
}
