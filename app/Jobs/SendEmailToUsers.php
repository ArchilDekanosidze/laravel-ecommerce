<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Notify\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Services\Message\MessageService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Message\Email\EmailService;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailToUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;

    /**
     * Create a new job instance.
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $users = User::whereNotNull('email')->get();
        foreach ($users as $user) {
            $emailService = new EmailService();
            $details = [
                'title' => $this->email->subject,
                'body' => $this->email->body
            ];
            $files = $this->email->files;
            $filePaths = [];
            foreach ($files as $file) {
                array_push($filePaths, $file->file_path);
            }
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com', 'example');
            $emailService->setSubject($this->email->subject);
            $emailService->setTo($user->email);
            $emailService->setEmailFiles($filePaths);
            $messagesService = new MessageService($emailService);
            $messagesService->send();            
        }
    }
}