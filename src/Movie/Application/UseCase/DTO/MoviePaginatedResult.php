<?php
declare (strict_types=1);

namespace App\Movie\Application\UseCase\DTO;

use App\Movie\Domain\Provider\PaginatedResultInterface;
use App\Shared\DTO\PaginatedResult;

class MoviePaginatedResult implements PaginatedResultInterface
{
    use PaginatedResult;
}