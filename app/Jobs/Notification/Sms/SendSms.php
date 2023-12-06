<?php

namespace App\Jobs\Notification\Sms;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Notification\Sms\SmsProvider;
use App\Services\Notification\Sms\Contracts\SmsSender;
use App\Services\Notification\Sms\Contracts\SmsSenderInterface;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $smsSender = new SmsProvider(app()->make(SmsSenderInterface::class));
        $smsSender->setUser($this->user);
        $smsSender->setData($this->data);
        return $smsSender->send();
    }
}
