<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_legacy_reports_route_redirects_logged_in_users_to_history(): void
    {
        config(['session.driver' => 'array']);

        $this->withoutMiddleware(\App\Http\Middleware\SincronizaConta::class)
            ->withSession(['usuario_id' => 1])
            ->get('/relatorios')
            ->assertRedirect('/historico');
    }

    public function test_legacy_reports_route_requires_login(): void
    {
        $this->get('/relatorios')->assertRedirect('/login');
    }
}
