<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_locale_is_indonesian(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('lang="id"', false);
        $response->assertSee('dir="ltr"', false);
    }

    public function test_user_can_switch_locale_to_english(): void
    {
        $response = $this->get(route('locale.switch', 'en'));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('locale', 'en');

        // Request with session locale
        $homeResponse = $this->withSession(['locale' => 'en'])->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('lang="en"', false);
        $homeResponse->assertSee('dir="ltr"', false);
    }

    public function test_user_can_switch_locale_to_arabic_with_rtl(): void
    {
        $response = $this->get(route('locale.switch', 'ar'));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('locale', 'ar');

        // Request with arabic session
        $homeResponse = $this->withSession(['locale' => 'ar'])->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('lang="ar"', false);
        $homeResponse->assertSee('dir="rtl"', false);
        $homeResponse->assertSee('Noto Kufi Arabic', false);
    }

    public function test_invalid_locale_is_ignored(): void
    {
        $response = $this->withSession(['locale' => 'id'])
            ->get(route('locale.switch', 'fr'));

        $response->assertRedirect(route('home'));
        $this->assertEquals('id', session('locale', 'id'));
    }
}
