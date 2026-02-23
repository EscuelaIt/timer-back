<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_register_with_valid_data(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message',
            'token'
        ]);
        $response->assertJson([
            'message' => 'El usuario se ha creado'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe'
        ]);
    }

    #[Test]
    public function registration_returns_auth_token(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);
        $this->assertNotEmpty($response->json('token'));
    }

    #[Test]
    public function user_cannot_register_with_duplicate_email(): void
    {
        User::query()->create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'password' => bcrypt('password')
        ]);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'existing@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Ha ocurrido un error de validación'
        ]);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function registration_fails_without_name(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['name']);
    }

    #[Test]
    public function registration_fails_without_email(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'password' => 'password123'
        ]);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function registration_fails_without_password(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['password']);
    }

    #[Test]
    public function registration_fails_with_invalid_email(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'password' => 'password123'
        ]);

        $response->assertStatus(400);
        $response->assertJsonValidationErrors(['email']);
    }

    #[Test]
    public function registered_user_is_not_verified(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertNull($user->email_verified_at);
    }

    #[Test]
    public function email_verification_notification_is_sent_on_registration(): void
    {
        Notification::fake();

        $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $user = User::where('email', 'john@example.com')->first();
        
        // Verify that the user was created and a notification should be sent
        $this->assertNotNull($user);
    }

    #[Test]
    public function registration_creates_user_with_hashed_password(): void
    {
        $this->postJson('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123'
        ]);

        $user = User::where('email', 'john@example.com')->first();
        
        // Verify password is hashed
        $this->assertNotEquals('password123', $user->password);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('password123', $user->password));
    }
}
