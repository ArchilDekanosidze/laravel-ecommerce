<?php

namespace App\Jobs\Notification\Sms;

use App\Services\Notification\Sms\SmsWithNumberProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $smssender = new SmsWithNumberProvider($this->phone_numbers, $this->data);
        return $smssender->send();
    }
}
