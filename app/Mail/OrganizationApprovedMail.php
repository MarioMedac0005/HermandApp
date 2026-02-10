<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganizationApprovedMail extends Mailable
{
    use SerializesModels;

    public function __construct(
        public User $user,
        public string $activationUrl
    ) {}

    public function build()
    {
        return $this
            ->subject('Tu solicitud ha sido aprobada')
            ->view('emails.organization-approved');
    }
}
