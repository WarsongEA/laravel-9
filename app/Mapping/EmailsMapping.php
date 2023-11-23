<?php

namespace App\Mapping;

use App\Dto\EmailCollectionDto;
use App\Dto\EmailDto;
use App\Http\Requests\SendEmailsRequest;

class EmailsMapping
{
    public static function requestToDtoList(SendEmailsRequest $emailsRequest): EmailCollectionDto
    {
        $mailsRequest = $emailsRequest->validated();
        $dtoCollection = new EmailCollectionDto();

        foreach ($mailsRequest['emails'] as $item) {
            $dto = new EmailDto(
                email: $item['toEmailAddress'],
                subject: $item['messageSubject'],
                body: $item['messageBody']
            );

            $dtoCollection->addEmailDto($dto);
        }

        return $dtoCollection;
    }

    public static function dtoListToArray(EmailCollectionDto $dtoList): array
    {
        $arr = [];

        foreach ($dtoList->getEmailDtos() as $item) {
            $arr[] = [
                'email' => $item->email,
                'subject' => $item->subject,
                'body' => $item->body,
            ];
        }

        return $arr;
    }

    public static function arrayItemToDto(array $item): EmailDto
    {
        return new EmailDto(
            email: $item['email'],
            subject: $item['subject'],
            body: $item['body']
        );
    }
}
