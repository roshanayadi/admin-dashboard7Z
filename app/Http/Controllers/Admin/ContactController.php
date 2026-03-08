<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(15);
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.contacts.index', compact('contacts', 'messages'));
    }

    public function show(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Contact message deleted.');
    }

    public function markRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return back()->with('success', 'Marked as read.');
    }
}
