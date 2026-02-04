<?php

namespace App\Mail;

use App\Models\OrganizationRequest;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganizationRejectedMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public OrganizationRequest $organizationRequest,
        public ?string $adminNotes,
        public string $retryUrl
    ) {}

    public function build()
    {
        return $this
            ->subject('Tu solicitud ha sido rechazada')
            ->view('emails.organization-rejected');
    }
}

