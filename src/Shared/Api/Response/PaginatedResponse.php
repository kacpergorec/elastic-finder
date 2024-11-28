<?php
declare (strict_types=1);

namespace App\Shared\Api\Response;

use Knp\Component\Pager\Pagination\PaginationInterface;

trait PaginatedResponse
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

    public static function fromPagination(PaginationInterface $pagination): self
    {
        return new self(
            $pagination->getItems(),
            new PaginationData(
                total: $pagination->getTotalItemCount(),
                limit: $pagination->getItemNumberPerPage(),
                currentPage: $pagination->getCurrentPageNumber(),
                lastPage: $pagination->getPageCount()
            )
        );
    }
}