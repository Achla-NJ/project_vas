<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
// use Illuminate\Contracts\Queue\ShouldQueue;

class UserNotification extends Mailable
{
    use Queueable, SerializesModels;

    //public $email_variables;
    public $email_subject;

    public $email_view_file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $email_variables, $email_subject, $email_view_file = 'general')
    {
        $this->viewData = $email_variables;
        //$this->email_variables = $email_variables;
        $this->email_view_file = $email_view_file;
        $this->email_subject = $email_subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): UserNotification
    {
        /*
        $compactArgs = [];
        foreach ($this->email_variables as $key => $value) {
            ${$key} = $value;
            $compactArgs[] = $key;
        }
        */

        return $this
            ->subject($this->email_subject)
            ->view("emails.{$this->email_view_file}");
    }
}
