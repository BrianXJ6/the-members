<?php

namespace App\Repositories;

use App\Models\{
    User,
    Topic,
    Message,
};

use App\Dto\SendMessageDto;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * List messages from a subscribed topic with logged in Users
     *
     * @param \App\Models\Topic $topic
     *
     * @return \Illuminate\Support\Collection
     */
    public function listMessagesFromTopicByLoggedUser(Topic $topic): Collection
    {
        $user = auth()->user();

        if (!$user->topics->contains($topic)) return collect();

        return $this->whereRelation('topic', 'topics.id', $topic->id)
            ->whereHasMorph(
                'messageable',
                [User::class],
                fn (Builder $query) => $query->where('id', $user->id)
            )->get();
    }
}
