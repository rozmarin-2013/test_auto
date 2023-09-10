<?php

namespace App\News\CreateNews;

use App\Request\CreateNewsInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class NewsCreateAction extends AbstractController
{
    public function __construct(private CreateNewsCommand $command)
    {
    }

    #[Route('/news', name: 'api_create_news', methods: 'POST')]
    public function __invoke(
        CreateNewsInput $input
    ): JsonResponse
    {
        try {
            $newsId = $this->command->execute($input);

            return new JsonResponse(['id' => $newsId]);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }
}