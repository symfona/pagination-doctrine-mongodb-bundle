<?php declare(strict_types=1);

namespace Symfona\DemoBundle\Tests\App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ExampleController
{
    #[Route]
    public function index(Request $request): JsonResponse
    {
        return new JsonResponse($request->getContent(), JsonResponse::HTTP_OK, [], true);
    }
}
