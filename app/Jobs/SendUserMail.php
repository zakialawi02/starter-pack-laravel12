<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $email, public string $name)
    {
        $this->onQueue('emails');
    }

    public function handle(): void
    {
        Mail::raw(
            "Hello {$this->name}, this is a queued email notification.",
            function ($message) {
                $message->to($this->email)
                    ->subject('Queued Email Notification');
            }
        );
    }

    public function tags(): array
    {
        return ['emails', "user:{$this->email}"];
    }
}
