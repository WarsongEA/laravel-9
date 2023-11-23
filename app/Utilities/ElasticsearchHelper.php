<?php

namespace App\Utilities;

use App\Dto\EmailDto;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Elasticsearch\Client;
use Illuminate\Support\Facades\Log;
use Throwable;

class ElasticsearchHelper implements ElasticsearchHelperInterface
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws Throwable
     */
    public function storeEmail(EmailDto $messageDto): mixed
    {
        $params = [
            'index' => 'emails',
            'body'  => [
                'email' => $messageDto->email,
                'subject' => $messageDto->subject,
                'body' => $messageDto->body,
                'timestamp' => date('c')
            ]
        ];

        try {
            return $this->client->index($params);
        } catch (Throwable $e) {
            Log::error('ElasticsearchHelper::storeEmail', ['e' => $e->getMessage(), 't' => $e->getTraceAsString()]);

            throw $e;
        }
    }
}
