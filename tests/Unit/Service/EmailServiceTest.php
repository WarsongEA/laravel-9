<?php

namespace Service;

use App\Dto\EmailCollectionDto;
use App\Dto\EmailDto;
use App\Jobs\SendEmail;
use App\Mail\EmailToSend;
use App\Service\EmailService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

/**
 * @covers \App\Service\EmailService
 */
class EmailServiceTest extends TestCase
{
    public function test_dispatch_list(): void
    {
        Queue::fake();
        $emailExpected = 'test@test.com';
        $subjectExpected = 'test-subject';
        $bodyExpected = 'test-body';
        $emailDto = new EmailDto(email: $emailExpected, subject: $subjectExpected, body: $bodyExpected);
        $dtoList = new EmailCollectionDto();
        $dtoList->addEmailDto($emailDto);

        $service = new EmailService();
        $service->dispatchList($dtoList);

        Queue::assertPushed(
            SendEmail::class,
            function (SendEmail $job) use ($emailDto, $emailExpected, $subjectExpected, $bodyExpected) {
                $assert = $job->emailDetails['email'] === $emailExpected;
                $assert = $assert && $job->emailDetails['subject'] === $subjectExpected;
                return $assert && $job->emailDetails['body'] === $bodyExpected;
            }
        );
    }

    public function test_send()
    {
        Mail::fake();

        $emailExpected = 'test@test.com';
        $subjectExpected = 'test-subject';
        $bodyExpected = 'test-body';
        $emailDto = new EmailDto(email: $emailExpected, subject: $subjectExpected, body: $bodyExpected);

        $service = new EmailService();
        $service->send($emailDto);

        Mail::assertSent(EmailToSend::class, function (EmailToSend $mail) use ($emailDto) {
            return $mail->hasTo($emailDto->email);
        });
    }
}
