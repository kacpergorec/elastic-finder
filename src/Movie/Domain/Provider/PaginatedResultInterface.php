<?php
declare (strict_types=1);

namespace App\Movie\Domain\Provider;

use App\Shared\DTO\PaginationData;

interface PaginatedResultInterface
{
    public function getData(): array;

    public function getPaginationData(): PaginationData;

    public static function fromPagination(PaginatedResultInterface $paginatedResult): self;
}