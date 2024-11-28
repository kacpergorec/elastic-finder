<?php
declare (strict_types=1);

namespace App\Shared\Api\Response;

use Knp\Component\Pager\Pagination\PaginationInterface;

interface PaginatedResponseInterface
{
    /**
     * @return mixed[]
     */
    public function getData(): array;

    public function getPaginationData(): PaginationData;

    public static function fromPagination(PaginationInterface $pagination): self;
}