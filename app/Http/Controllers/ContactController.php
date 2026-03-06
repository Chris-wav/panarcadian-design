<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\ContactSubmitted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => ['required', 'string', 'min:2'],
            'phone' => ['nullable', 'string'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string', 'min:5'],
        ]);

        $contact = \App\Models\Contact::create($validated);

        Mail::to('admin@example.com')
            ->send(new ContactSubmitted($contact));

        return redirect()
            ->back()
            ->with('success', 'Message was sent successfully.');
    }
}
