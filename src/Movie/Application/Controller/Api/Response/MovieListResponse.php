<?php
declare (strict_types=1);

namespace App\Movie\Application\Controller\Api\Response;

use App\Movie\Domain\Provider\PaginatedResultInterface;
use App\Shared\DTO\PaginatedResult;

final readonly class MovieListResponse implements PaginatedResultInterface
{
    use PaginatedResult;
}