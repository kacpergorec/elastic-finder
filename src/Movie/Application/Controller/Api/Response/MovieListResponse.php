<?php
declare (strict_types=1);

namespace App\Movie\Application\Controller\Api\Response;

use App\Shared\Api\Response\PaginatedResponse;
use App\Shared\Api\Response\PaginatedResponseInterface;

final readonly class MovieListResponse implements PaginatedResponseInterface
{
    use PaginatedResponse;
}