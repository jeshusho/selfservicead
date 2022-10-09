<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationScheduledTask extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notificaciones Vencimiento de Contraseña AD  - Revisar Tarea Programada')
                ->view('mail.notification-scheduled-task')
                ->with([
                   // 'logo_url' => $this->aduser->logo_url,
                    'dt_notification' => $this->data->dt_notification,
                    'dt_last_scheduled_task' => $this->data->dt_last_scheduled_task,
                    'delay_minutes' => $this->data->delay_minutes,
                ]);
    }
}
