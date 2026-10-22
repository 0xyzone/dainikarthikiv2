<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/app/login');

        $response->assertStatus(200);
        $response->assertSee('Dainik Arthiki OS');
        $response->assertSee('Welcome Back');
        $response->assertSee('passkey-login-form');
    }

    public function test_user_can_authenticate_via_login_form(): void
    {
        $user = User::factory()->create([
            'email' => 'finance@dainikarthiki.com',
            'password' => bcrypt('SecurePassword123!'),
        ]);

        Livewire::test(\App\Filament\App\Pages\Auth\Login::class)
            ->fillForm([
                'email' => 'finance@dainikarthiki.com',
                'password' => 'SecurePassword123!',
            ])
            ->call('authenticate')
            ->assertHasNoFormErrors();

        $this->assertAuthenticatedAs($user);
    }
}
