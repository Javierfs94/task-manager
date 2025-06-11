<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\App;

class SetLocaleMiddlewareTest extends TestCase
{
    public function test_it_sets_locale_from_cookie()
    {
        $response = $this->withCookie('locale', 'es')->get('/'); // Ajusta la ruta si es necesario

        $this->assertEquals('es', App::getLocale());
    }
}
