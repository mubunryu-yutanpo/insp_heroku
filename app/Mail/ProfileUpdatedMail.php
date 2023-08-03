<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfileUpdatedMail extends Mailable{
    
    use Queueable, SerializesModels;

    public $isEmailUpdated;
    public $user;
    public $oldEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(bool $isEmailUpdated, $user, $oldEmail)
    {
        $this->isEmailUpdated = $isEmailUpdated;
        $this->user = $user;
        $this->oldEmail = $oldEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'プロフィールが更新されました';

        return $this->subject($subject)
                    ->view('email.profile-updated')
                    ->with([
                        'isEmailUpdated' => $this->isEmailUpdated,
                        'user' => $this->user,
                        'oldEmail' => $this->oldEmail,
                    ]);
    }
}
