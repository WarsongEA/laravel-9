<?php

namespace App\Service;

use App\Dto\EmailCollectionDto;
use App\Dto\EmailDto;
use App\Jobs\SendEmail;
use App\Mail\EmailToSend;
use App\Mapping\EmailsMapping;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function dispatchList(EmailCollectionDto $dtoList): void
    {
        $arr = EmailsMapping::dtoListToArray($dtoList);

        foreach ($arr as $item) {
            SendEmail::dispatch($item);
        }
    }

    public function send(EmailDto $dto): void
    {
        $emailToSend = new EmailToSend($dto);

        Mail::to($dto->email)->send($emailToSend);
    }

    /**
     * @throws BindingResolutionException
     */
    public function remember(EmailDto $emailDto): void
    {
        /** @var ElasticsearchHelperInterface $elasticsearchHelper */
        $elasticsearchHelper = app()->make(ElasticsearchHelperInterface::class);
        /** @var RedisHelperInterface $redisHelper */
        $redisHelper = app()->make(RedisHelperInterface::class);

        $elasticsearchObj = $elasticsearchHelper->storeEmail(messageDto: $emailDto);
        $id = $elasticsearchObj['_id'];
        $redisHelper->storeRecentMessage(id: $id, messageSubject: $emailDto->subject, toEmailAddress: $emailDto->email);
    }
}
