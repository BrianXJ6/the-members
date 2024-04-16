<?php

namespace App\Jobs;

use App\Models\Topic;
use Illuminate\Queue\{
    SerializesModels,
    InteractsWithQueue,
};

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\NotificationNewMsgInTopic as MailNotificationNewMsgInTopic;

class NotificationNewMsgInTopic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param string $userName
     * @param \App\Models\Topic $topic
     */
    public function __construct(
        private string $userName,
        private Topic $topic,
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $emails = $this->topic->users->pluck('email')->toArray();

        Mail::to($emails)->queue(new MailNotificationNewMsgInTopic(
            $this->userName,
            $this->topic->name,
        ));
    }
}
