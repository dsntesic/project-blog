<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMailForm;

class ContactController extends Controller
{
    public function index() 
    {
        return view('front.contact.index');
    }
    
    public function sendMessage(Request $request) 
    {
        $formData = $request->validate([
            'contact_person' => ['required','string','between:2,255'],
            'contact_email' => ['required','email','max:255'],
            'message' => ['required','string','between:50,500'],
            'g-recaptcha-response' => ['required','recaptcha'],
        ]);
        Mail::to('dsntesic1985@gmail.com')
            ->send(new ContactMailForm($formData['contact_person'],$formData['contact_email'],$formData['message']));
        
        session()->flash('system_message',__('Your message has been received, we will contact you soon'));
        return redirect()->back(); 
    }
}
