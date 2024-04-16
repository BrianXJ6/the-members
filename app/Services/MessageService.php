<?php

namespace App\Services;

use App\Models\{
    Topic,
    Message,
};

use App\Dto\SendMessageDto;
use App\Jobs\NotificationNewMsgInTopic;
use App\Repositories\MessageRepository;

class MessageService extends BaseService
{
    /**
     * Create a new Message Service instance
     *
     * @param \App\Repositories\MessageRepository $messageRepository
     */
    public function __construct(private MessageRepository $messageRepository)
    {
        parent::__construct($messageRepository);
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
        $message = $this->messageRepository->sendMessage($data, $topic);
        NotificationNewMsgInTopic::dispatch($data->messageable->name, $topic);

        return $message;
    }
}
