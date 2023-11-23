<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Notify\SMS;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use App\Services\Message\MessageService;
use App\Services\Message\SMS\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendSmsToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sms;

    /**
     * Create a new job instance.
     */
    public function __construct(SMS $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $users = User::whereNotNull('mobile')->get();
        foreach ($users as $user) {
            //send sms
            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0' . $user->mobile]);
            $smsService->setText($this->sms->body);
            $smsService->setIsFlash(true);

            $messagesService = new MessageService($smsService);
            $messagesService->send();
        }
    }
}