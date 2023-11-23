<?php

namespace App\Jobs;

use App\Mapping\EmailsMapping;
use App\Service\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public function __construct(public array $emailDetails)
    {
    }


    /**
     * @throws BindingResolutionException
     */
    public function handle(EmailService $emailService): void
    {
        $emailDto = EmailsMapping::arrayItemToDto($this->emailDetails);

        $emailService->send($emailDto);
        $emailService->remember($emailDto);
    }
}
