<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class LanguageController extends Controller
{
    public function switchLang($locale)
    {
        if (!in_array($locale, ['en', 'es'])) {
            abort(400, 'Invalid locale');
        }

        // Poner cookie válida por 1 año
        Cookie::queue('locale', $locale, 60 * 24 * 365);

        return redirect()->back();
    }
}
