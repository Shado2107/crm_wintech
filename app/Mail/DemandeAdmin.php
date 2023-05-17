<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($demande)
    {
        //
        $this->demande = $demande;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $text = 'Nouvelle demande de paiement enregistrée';
      $path2 = "- " ;
        return $this->subject('Nouvelle demande de paiement enregistrée')->view('mail.demande_transaction', ['demande'=> $this->demande]);
    }
}
