<?php

namespace App\Jobs\Notification\Sms;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Notification\Sms\SmsWithNumberProvider;
use App\Services\Notification\Sms\Contracts\SmsSenderInterface;

class SendSmsWithNumber implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $phone_numbers;
    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct($phone_numbers, array $data)
    {
        $this->phone_numbers = $phone_numbers;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $smsSender = new SmsWithNumberProvider(app()->make(SmsSenderInterface::class));
        $smsSender->setPhoneNumber($this->phone_numbers);
        $smsSender->setData($this->data);
        return $smsSender->send();
    }
}
