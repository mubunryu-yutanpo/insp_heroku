<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerifyEmailJapanese extends VerifyEmail
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //         ->subject('登録確認メール') // メールのタイトル
    //         ->view('email.verifyemail', ['url' => $this->verificationUrl($notifiable), 'user' => $notifiable]);
    // }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('メールアドレスの確認') // メールのタイトル
            ->action('メールアドレスの確認', $this->verificationUrl($notifiable)) // 修正：$this->verificationUrl()を使用
            ->line('このボタンを押して本登録を完了させてください。')
            ->line('よろしくお願いいたします。');
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