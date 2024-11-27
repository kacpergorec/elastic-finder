<?php
declare (strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController
{
    #[Route('/')]
    public function index(): Response
    {
        return new Response('Hello multiverse!');
    }
}