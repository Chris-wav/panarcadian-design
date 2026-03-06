<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactSubmitted;
use App\Models\Contact;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_submits_successfully()
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'fullname' => 'John Doe',
            'phone' => '123456789',
            'email' => 'john@example.com',
            'message' => 'This is a test message'
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('contacts', [
            'email' => 'john@example.com'
        ]);

        Mail::assertSent(ContactSubmitted::class);
    }
    public function test_contact_form_fails_when_required_fields_are_missing()
{
    Mail::fake();

    $response = $this->post('/contact', [
        'fullname' => '',
        'phone' => '',
        'email' => '',
        'message' => ''
    ]);

    $response->assertSessionHasErrors([
        'fullname',
        'email',
        'message'
    ]);

    $this->assertDatabaseCount('contacts', 0);

    Mail::assertNothingSent();
}
}
