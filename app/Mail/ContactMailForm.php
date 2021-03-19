<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMailForm extends Mailable
{
    use Queueable, SerializesModels;
    
    protected  $contactPerson;
    protected  $contactEmail;
    protected  $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contactPerson,$contactEmail,$message)
    {
        $this->setContactPerson($contactPerson);
        $this->setContactEmail($contactEmail);
        $this->setMessage($message);
    }
    
    public function getContactPerson() {
        return $this->contactPerson;
    }

    public function getContactEmail() {
        return $this->contactEmail;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setContactPerson($contactPerson) {
        $this->contactPerson = $contactPerson;
        return $this;
    }

    public function setContactEmail($contactEmail) {
        $this->contactEmail = $contactEmail;
        return $this;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $this->from(config('mail.username'))
             ->replyTo($this->getContactEmail())
             ->subject(__('You have new message on contact form'));
        return $this->view('front.emails.contact_message')
             ->with([
                 'contactPerson' => $this->getContactPerson(),
                 'contactMessage' => $this->getMessage(),
             ]);
    }
}
