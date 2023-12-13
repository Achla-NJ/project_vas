<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
class CompanyMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $subject;
    public $view;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details,$subject , $view , $files ="")
    {
        $this->details = $details;
        $this->subject = $subject;
        $this->view = $view;
        $this->attachment = $files;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    /**
     * Build the message.
     *
     * @return $this
     */
     /**
     * Get the message envelope.
     */
    

    /**
     * Get the message content definition.
     */
    
    
    public function build()
    {
        $this->subject($this->subject)->view("emails.{$this->view}");    

        if ($this->attachment) {
            foreach($this->attachment as $key => $file) 
            $this->attach($file);            
        }

        return $this;
    }
}
