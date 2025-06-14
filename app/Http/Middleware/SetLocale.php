<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class SetLocale
{

    public function handle(Request $request, Closure $next)
    {
        if ($locale = $request->cookie('locale')) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
