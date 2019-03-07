<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ParamReferenciales;

class NotificaAvance extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

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
        $asunto = ParamReferenciales::valor('Correo','Asunto-Avances');
        $cc = ParamReferenciales::valor('Correo','Email-Administrador');
        return $this->view('email.avances')
        ->subject($asunto)
        ->cc($cc,$this->data[6]);
    }
}
