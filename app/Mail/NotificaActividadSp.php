<?php

namespace App\Mail;

use App\ParamReferenciales;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificaActividadSp extends Mailable
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
        $asunto = ParamReferenciales::valor('Correo', 'Asunto-Actividades');
        //$cc = ParamReferenciales::valor('Correo', 'Email-Administrador');
        return $this->view('email.actividadessp')
            ->subject($asunto)
            ->cc('crispal94@hotmail.com');
    }
}
