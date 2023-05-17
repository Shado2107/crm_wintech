<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationApprenant extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inviter,$formateur)
    {
        $this->inviter = $inviter;
        $this->formateur = $formateur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $text = 'vous a invité sur Move Skills';
      $path2 = "- " ;
        return $this->subject($this->inviter->prenom. ",". $this->formateur->prenom. " " . $text )->view('mail.bienvenue_apprenant', ['inviter'=> $this->inviter,'formateur'=> $this->formateur]);
    }
}
