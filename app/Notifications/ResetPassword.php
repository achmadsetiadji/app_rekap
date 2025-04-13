<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     *
     * @var mixed
     */
    public $token;

    /**
     *
     * @var mixed
     */
    public $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(mixed $token, mixed $email)
    {
        $this->token = $token;
        $this->email = $email;
    }    

    /**
     * Get the notification's delivery channels.
     *
     * @return array<mixed>
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage)
        ->subject('Reset Password')
        ->line('Anda menerima email ini karena kami menerima permintaan penyetelan ulang sandi untuk akun Anda.')
        ->action('Reset Password', url('reset-password', $this->token).'?email='.$this->email)
        ->line('Jika anda tidak berniat mengganti password, jangan klik link di atas dan abaikan email ini.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<mixed>
     */
    public function toArray()
    {
        return [
            //
        ];
    }
}
