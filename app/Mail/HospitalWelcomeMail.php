<?php

namespace Medom\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Medom\Modules\Auth\Models\User;


class HospitalWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Your Medom Hospital Account Creation")
            ->view('mails.hospital-welcome', ["user" => $this->user, "password" => $this->password]);
    }
}
