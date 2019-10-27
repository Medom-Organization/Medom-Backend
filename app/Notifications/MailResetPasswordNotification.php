<?php

namespace Travellab\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MailResetPasswordNotification extends Notification
{
    use Queueable, SerializesModels;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // if(static::$toMailCallback){
        //     return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        // }
        // return(new MailMessage)
        //   ->subject(Lang::getFromJson('Reset Password Notification'))
        //   ->line(Lang::getFromJson(
        //       'You are receiving this email beacause we received a password reset request for your account.'))
        //       ->action(Lang::getFromJson('Reset Password'), url(config('app.url').route(
        //           'passworder.reset', $this->token, false)))
        //           ->line(Lang::getFromJson(
        //               'If you did not request a password reset, no further action is required'));



        return $this->
        subject("Reset Password Notification")
        ->line('You are receiving this email beacause we received a password reset request for your account.')
        ->view('mails.reset-password',["user"=>$this->user]);

        
        // // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
