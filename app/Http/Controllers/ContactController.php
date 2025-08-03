<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    /**
     * Display the contact form.
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Store a new contact form submission.
     */
    public function store(ContactRequest $request)
    {
        try {
            // Create contact record
            $contact = Contact::create($request->validated());

            // Send notification email (optional)
            // Mail::to('admin@yoursite.com')->send(new ContactFormSubmitted($contact));

            return redirect()->back()->with('success', __('messages.contact_success', [
                'default' => 'Thank you for your message! We will get back to you soon.'
            ]));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.contact_error', [
                'default' => 'Sorry, there was an error sending your message. Please try again.'
            ]))->withInput();
        }
    }

    /**
     * Display all contact submissions (for admin).
     */
    public function admin()
    {
        $contacts = Contact::latest()->paginate(20);
        
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show a specific contact submission (for admin).
     */
    public function show(Contact $contact)
    {
        // Mark as read when viewed
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update contact status (for admin).
     */
    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied'
        ]);

        $contact->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Contact status updated successfully.');
    }

    /**
     * Delete a contact submission (for admin).
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}