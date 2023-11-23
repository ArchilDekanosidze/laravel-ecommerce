<?php

namespace App\Jobs\Notification\Sms;

use App\Services\Notification\Sms\SmsToMultipleUserProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $smssender = new SmsToMultipleUserProvider($this->multipleUser, $this->data);
        return $smssender->send();
    }
}
