<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestEmail extends Mailable {
  use SendGrid;

  public function build() {
    $address = 'support@blls.io';
    $subject = 'This is a test message from Blls.io!';
    $name = 'Blls.io';

    return $this
    ->from($address, $name)
    ->cc($address, $name)
    ->bcc($address, $name)
    ->replyTo($address, $name)
    ->subject($subject)
    ->with([ 'message' => $this->data['message'] ]);
    ->sendgrid([
      'personalizations' => [
        [
          'substitutions' => [
            ':myname' => 'blls',
          ],
        ],
      ],
    ]);
  }
}
