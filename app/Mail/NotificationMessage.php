<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $aduser;
    protected $parameters;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($aduser, $parameters)
    {
        $this->aduser = $aduser;
        $this->parameters = $parameters;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('¡Renueva tu contraseña!... Y evita tener inconvenientes con el acceso a nuestros Sistemas.')
                ->markdown('mail.notification-message')
                ->with([
                    'given_name' => $this->aduser->given_name,
                    'username' => $this->aduser->username,
                    'expiration_days' => $this->aduser->expiration_days,
                    'principal_link_text' => $this->parameters->principal_link_text,
                    'principal_link_url' => $this->parameters->principal_link_url,
                    'mda_whatsapp_text' => $this->parameters->mda_whatsapp_text,
                    'mda_whatsapp_url' => $this->parameters->mda_whatsapp_url,
                    'mda_phone_text' => $this->parameters->mda_phone_text,
                    'mda_phone_url' => $this->parameters->mda_phone_url,
                    'mda_extension_text' => $this->parameters->mda_extension_text,
                    'mda_portal_text' => $this->parameters->mda_portal_text,
                    'mda_portal_url' => $this->parameters->mda_portal_url,
                    'mda_mail_text' => $this->parameters->mda_mail_text,
                    'mda_mail_url' => $this->parameters->mda_mail_url,
                    'portal_text' => $this->parameters->portal_text,
                    'portal_url' => $this->parameters->portal_url,
                ]);
    }
}
