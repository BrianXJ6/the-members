<?php

namespace App\Repositories;

use App\Models\{
    Topic,
    Message,
};

use App\Dto\SendMessageDto;

class MessageRepository extends BaseRepository
{
    /** @inheritdoc */
    public function modelClass(): string
    {
        return Message::class;
    }

    /**
     * Post a message to a specific topic
     *
     * @param \App\Dto\SendMessageDto $data
     * @param \App\Models\Topic $topic
     *
     * @return \App\Models\Message
     */
    public function sendMessage(SendMessageDto $data, Topic $topic): Message
    {
        $message = $this->model;
        $message->text = $data->message;
        $message->topic()->associate($topic);
        $message->messageable()->associate($data->messageable);
        $message->save();

        return $message;
    }
}
