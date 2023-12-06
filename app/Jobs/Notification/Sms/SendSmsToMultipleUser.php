<?php

namespace App\Jobs\Notification\Sms;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Notification\Sms\SmsToMultipleUserProvider;
use App\Services\Notification\Sms\Contracts\SmsSenderInterface;

class SendSmsToMultipleUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $multipleUser;
    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct($multipleUser, array $data)
    {
        $this->multipleUser = $multipleUser;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $smsSender = new SmsToMultipleUserProvider(app()->make(SmsSenderInterface::class));
        $smsSender->setUsers($this->multipleUser);
        $smsSender->setData($this->data);
        return $smsSender->send();
    }
}
