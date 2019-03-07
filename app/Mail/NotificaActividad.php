<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ParamReferenciales;

class NotificaActividad extends Mailable
{
    use Queueable, SerializesModels;

     public $data;

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
        $asunto = ParamReferenciales::valor('Correo','Asunto-Actividades');
        $cc = ParamReferenciales::valor('Correo','Email-Administrador');
        return $this->view('email.actividades')
        ->subject($asunto)
        ->cc($cc);
    }
}
