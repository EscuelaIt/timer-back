<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EmailVerificationApiControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function resend_verification_email_with_valid_token(): void
    {
        $user = User::query()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => null
        ]);

        $token = $user->createToken('API ACCESS TOKEN')->plainTextToken;

        $response = $this->postJson('/api/auth/email/resend-verification', [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Email de verificación reenviado. Revisa tu bandeja de entrada.'
        ]);
    }

    #[Test]
    public function cannot_resend_verification_if_already_verified(): void
    {
        $user = User::query()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);

        $token = $user->createToken('API ACCESS TOKEN')->plainTextToken;

        // Mark email as verified
        $user->markEmailAsVerified();

        $response = $this->postJson('/api/auth/email/resend-verification', [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'El email ya está verificado'
        ]);
    }

    #[Test]
    public function resend_verification_requires_authentication(): void
    {
        $response = $this->postJson('/api/auth/email/resend-verification');

        $response->assertStatus(401);
    }

    #[Test]
    public function resend_verification_requires_valid_token(): void
    {
        $response = $this->postJson('/api/auth/email/resend-verification', [], [
            'Authorization' => 'Bearer invalid-token'
        ]);

        $response->assertStatus(401);
    }
}
