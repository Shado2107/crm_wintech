<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMoveskills extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$formateur)
    {
        $this->user = $user;
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
        return $this->subject($this->user->prenom. ",". $this->formateur->prenom. " " . $text )->view('mail.bienvenue_invitation', ['user'=> $this->user,'formateur'=> $this->formateur]);
    }
}
