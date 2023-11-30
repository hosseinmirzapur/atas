<?php

namespace App\Jobs;

use App\Mail\UserRegisterOtpMail;
use App\Repository\Structure\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCodeToEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $email;
    protected int|string $code;
    protected UserRepository $repo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $code)
    {
        $this->email = $email;
        $this->code = $code;
        $this->repo = new UserRepository();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->repo->findOneByAttr('email', $this->email);
        $code = $this->code;
        Mail::to($user)->send(new UserRegisterOtpMail($code));
    }
}
