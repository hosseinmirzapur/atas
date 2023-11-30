<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegisterOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    protected int|string $code;

    /**
     * Create a new message instance.
     *
     * @param $code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $code = $this->code;
        return $this->view('view.otp', compact('code'));
    }
}
