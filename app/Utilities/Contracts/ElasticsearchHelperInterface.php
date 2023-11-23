<?php

namespace App\Utilities\Contracts;

use App\Dto\EmailDto;

interface ElasticsearchHelperInterface {
    /**
     * Store the email's message body, subject and to address inside elasticsearch.
     *
     * @param EmailDto $messageDto
     * @return mixed - Return the id of the record inserted into Elasticsearch
     */
    public function storeEmail(EmailDto $messageDto): mixed;
}
