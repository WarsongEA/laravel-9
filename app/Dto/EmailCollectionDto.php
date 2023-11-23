<?php

namespace App\Dto;

class EmailCollectionDto
{
    private array $emailDtos;

    public function addEmailDto(EmailDto $dto): void
    {
        $this->emailDtos[] = $dto;
    }

    /**
     * @return EmailDto[]
     */
    public function getEmailDtos(): array
    {
        return $this->emailDtos;
    }
}
