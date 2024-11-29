<?php
declare (strict_types=1);

namespace App\Shared\DTO;

use App\Movie\Domain\Provider\PaginatedResultInterface;

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

    public static function fromPagination(PaginatedResultInterface $paginatedResult): self
    {
        return new self(
            data: $paginatedResult->getData(),
            paginationData: $paginatedResult->getPaginationData()
        );
    }
}