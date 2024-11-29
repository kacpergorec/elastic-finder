<?php
declare (strict_types=1);

namespace App\Shared\DTO;

final readonly class PaginationData
{
    public function __construct(
        public int $total,
        public int $limit,
        public int $currentPage,
        public int $lastPage
    )
    {
    }
}