<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewCompanyEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $company;
    protected $fromAddress;
    protected $toAddress;

    /**
     * Create a new message instance.
     */
    public function __construct(Company $company, $fromAddress, $toAddress)
    {
        $this->company = $company;
        $this->fromAddress = $fromAddress;
        $this->toAddress = $toAddress;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Company Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    public function build()
    {
        $name = $this->company->name;
        $email = $this->company->email;
        $website = $this->company->website;

        $content = "
            <h1>New Company Created</h1>
            <p>A new company has been created:</p>
            <ul>
                <li><strong>Name:</strong> $name</li>
                <li><strong>Email:</strong> $email</li>
                <li><strong>Website:</strong> $website</li>
            </ul>
        ";

        return $this->from($this->fromAddress)
                    ->to($this->toAddress)
                    ->subject('New Company Created')
                    ->html($content);
    }
}
