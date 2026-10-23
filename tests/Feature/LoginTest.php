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
        $response->assertSee('auth-card-shell');
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

    public function test_register_page_renders_successfully(): void
    {
        $response = $this->get('/app/register');

        $response->assertStatus(200);
        $response->assertSee('Dainik Arthiki OS');
        $response->assertSee('Create Free Account');
        $response->assertSee('auth-card-shell');
    }

    public function test_user_can_register_via_registration_form(): void
    {
        \Filament\Facades\Filament::setCurrentPanel(\Filament\Facades\Filament::getPanel('app'));

        Livewire::test(\App\Filament\App\Pages\Auth\Register::class)
            ->fillForm([
                'name' => 'Aayush Shrestha',
                'email' => 'aayush@dainikarthiki.com',
                'password' => 'SecurePassword123!',
                'passwordConfirmation' => 'SecurePassword123!',
            ])
            ->call('register')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', [
            'email' => 'aayush@dainikarthiki.com',
            'name' => 'Aayush Shrestha',
        ]);
    }

    public function test_email_verification_notification_dispatches_successfully(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        \Illuminate\Support\Facades\Notification::fake();

        $user->sendEmailVerificationNotification();

        \Illuminate\Support\Facades\Notification::assertSentTo(
            $user,
            \Filament\Auth\Notifications\VerifyEmail::class,
            function ($notification) use ($user) {
                return str_contains($notification->url, '/app/email-verification/verify/' . $user->getKey());
            }
        );
    }
}
