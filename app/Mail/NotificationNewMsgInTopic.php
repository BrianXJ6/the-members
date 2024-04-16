<?php

namespace App\Mail;

use Illuminate\Mail\Mailables\{
    Content,
    Envelope,
};

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationNewMsgInTopic extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param string $userName
     * @param string $topicName
     */
    public function __construct(
        private string $userName,
        private string $topicName,
    ) {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: "A new message was sent in the topic: {$this->topicName}");
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail',
            with: [
                'user_name' => $this->userName,
                'topic_name' => $this->topicName,
            ]
        );
    }
}
