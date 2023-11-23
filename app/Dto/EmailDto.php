<?php

namespace App\Dto;

readonly class EmailDto
{
    public function __construct(
        public string $email,
        public string $subject,
        public string $body,
    )
    {
    }
}
