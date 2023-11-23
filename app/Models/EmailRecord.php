<?php

namespace App\Models;

use Elasticsearch\Client;

class EmailRecord
{
    public function __construct(protected Client $client)
    {
    }

    public function all(): array
    {
        $params = [
            'index' => 'emails',
            'body'  => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ];

        $response = $this->client->search($params);

        return array_column($response['hits']['hits'], '_source');
    }
}
