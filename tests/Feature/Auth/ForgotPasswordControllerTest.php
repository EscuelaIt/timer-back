<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function forgot_password_sends_reset_link_with_valid_email(): void
    {
        Mail::fake();

        User::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/auth/forgot-password', [
            'email' => 'john@example.com'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Email de reset enviado correctamente'
        ]);
    }

    #[Test]
    public function forgot_password_fails_with_invalid_email_format(): void
    {
        $response = $this->postJson('/api/auth/forgot-password', [
            'email' => 'invalid-email'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Error de validación'
        ]);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function forgot_password_fails_when_email_not_found(): void
    {
        $response = $this->postJson('/api/auth/forgot-password', [
            'email' => 'nonexistent@example.com'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Error de validación'
        ]);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function forgot_password_fails_without_email(): void
    {
        $response = $this->postJson('/api/auth/forgot-password', []);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Error de validación'
        ]);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function reset_password_updates_password_with_valid_token(): void
    {
        $user = User::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('oldpassword')
        ]);

        $token = Password::createToken($user);

        $response = $this->postJson('/api/auth/reset-password', [
            'email' => 'john@example.com',
            'token' => $token,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Contraseña reseteada correctamente'
        ]);

        $user->refresh();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('newpassword123', $user->password));
    }

    #[Test]
    public function reset_password_fails_with_invalid_token(): void
    {
        User::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/auth/reset-password', [
            'email' => 'john@example.com',
            'token' => 'invalid-token-12345',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'El token de reset es inválido o ha expirado'
        ]);
    }

    #[Test]
    public function reset_password_fails_with_mismatched_passwords(): void
    {
        $user = User::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        $token = Password::createToken($user);

        $response = $this->postJson('/api/auth/reset-password', [
            'email' => 'john@example.com',
            'token' => $token,
            'password' => 'newpassword123',
            'password_confirmation' => 'differentpassword'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Error de validación'
        ]);
        $response->assertJsonValidationErrors(['password']);
    }

    #[Test]
    public function reset_password_fails_with_short_password(): void
    {
        $user = User::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        $token = Password::createToken($user);

        $response = $this->postJson('/api/auth/reset-password', [
            'email' => 'john@example.com',
            'token' => $token,
            'password' => 'short',
            'password_confirmation' => 'short'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Error de validación'
        ]);
        $response->assertJsonValidationErrors(['password']);
    }

    #[Test]
    public function reset_password_fails_without_email(): void
    {
        $response = $this->postJson('/api/auth/reset-password', [
            'token' => 'some-token',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Error de validación'
        ]);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function reset_password_fails_without_token(): void
    {
        User::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/auth/reset-password', [
            'email' => 'john@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Error de validación'
        ]);
        $response->assertJsonValidationErrors(['token']);
    }

    #[Test]
    public function reset_password_fails_without_password(): void
    {
        $user = User::query()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password')
        ]);

        $token = Password::createToken($user);

        $response = $this->postJson('/api/auth/reset-password', [
            'email' => 'john@example.com',
            'token' => $token
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Error de validación'
        ]);
        $response->assertJsonValidationErrors(['password']);
    }

    #[Test]
    public function reset_password_fails_with_nonexistent_email(): void
    {
        $response = $this->postJson('/api/auth/reset-password', [
            'email' => 'nonexistent@example.com',
            'token' => 'some-token',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Error de validación'
        ]);
        $response->assertJsonValidationErrors(['email']);
    }
}
