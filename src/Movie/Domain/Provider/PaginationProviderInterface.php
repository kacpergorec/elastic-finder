<?php
declare (strict_types=1);

namespace App\Movie\Domain\Provider;

use Knp\Component\Pager\Pagination\PaginationInterface;

interface PaginationProviderInterface
{
    /**
     * @param mixed[] $filters
     */
    public function paginate(int $page, int $limit, array $filters = []): PaginatedResultInterface;
}