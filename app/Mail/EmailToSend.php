<?php

namespace App\Mail;

use App\Dto\EmailDto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailToSend extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public EmailDto $dto)
    {
    }

    public function build(): EmailToSend
    {
        return $this
            ->subject($this->dto->subject)
            ->view('emails.template', ['body' => $this->dto->body]);
    }
}
