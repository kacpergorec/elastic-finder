<?php
declare (strict_types=1);

namespace App\Shared\DTO;

trait PaginatedResult
{
    public function __construct(
        /** @var mixed[] */
        private readonly array $data,
        private readonly PaginationData $paginationData
    )
    {
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getPaginationData(): PaginationData
    {
        return $this->paginationData;
    }
}