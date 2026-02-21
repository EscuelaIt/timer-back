<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PasswordResetControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function password_reset_view_is_accessible(): void
    {
        $token = 'test-token-123';

        $response = $this->get("/password/reset/{$token}");

        $response->assertStatus(200);
        $response->assertViewIs('auth.reset-password');
    }

    #[Test]
    public function password_reset_view_receives_token(): void
    {
        $token = 'test-token-456';

        $response = $this->get("/password/reset/{$token}");

        $response->assertStatus(200);
        $response->assertViewHas('token', $token);
    }

    #[Test]
    public function password_reset_view_with_special_characters_in_token(): void
    {
        $token = 'test-token-with-special_chars.123';

        $response = $this->get("/password/reset/{$token}");

        $response->assertStatus(200);
        $response->assertViewHas('token', $token);
    }

    #[Test]
    public function password_reset_view_displays_correct_form(): void
    {
        $token = 'test-token-789';

        $response = $this->get("/password/reset/{$token}");

        $response->assertStatus(200);
        $response->assertSee('Reset Password');
        $response->assertSee('Email');
        $response->assertSee('New Password');
        $response->assertSee('Confirm Password');
    }

    #[Test]
    public function password_reset_view_contains_form_fields(): void
    {
        $token = 'test-token-abc';

        $response = $this->get("/password/reset/{$token}");

        $response->assertStatus(200);
        // Verify form fields are present in the HTML content
        $content = $response->getContent();
        $this->assertStringContainsString('type="email"', $content);
        $this->assertStringContainsString('type="password"', $content);
        $this->assertStringContainsString('type="hidden"', $content);
        $this->assertStringContainsString('Reset Password', $content);
    }

    #[Test]
    public function password_reset_route_is_named_correctly(): void
    {
        $token = 'test-token-def';
        $url = route('password.reset', ['token' => $token]);

        $this->assertStringContainsString("/password/reset/{$token}", $url);
    }
}
