<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemandeFormateur extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $demande)
    {
        //
        
        $this->user = $user;
        $this->demande = $demande;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $text = 'Votre paiement a été effectué avec succès';
      $path2 = "- " ;
        return $this->subject($this->user->prenom. ",". " " . $text )->view('mail.transaction_valider', ['user'=> $this->user, 'demande'=> $this->demande]);
    }
}
