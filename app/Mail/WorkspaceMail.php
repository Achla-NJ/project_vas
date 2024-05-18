<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
class WorkspaceMail extends Mailable
{
    use Queueable, SerializesModels;
    // public $details;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $files ="")
    {
        // $this->details = $details;
        $this->subject = $subject;
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
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function build()
    {
        $this->subject($this->subject)->view("emails.blank-mail");

        if ($this->attachment) {
            // Attach PDF file
            $this->attachData($this->attachment->output(), 'invoice.pdf', ['mime' => 'application/pdf']);
        }

        return $this;
    }
}
