<?php

namespace App\News\GetNews;

use App\News\NewsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetNewsAction
{
    public function __construct(private NewsRepository $newsRepository)
    {
    }

    #[Route('/news/{id}', name: 'api_get_news', methods: 'GET')]
    public function __invoke(string $id)
    {
        try {
            return new JsonResponse(
                GetNewsOutput::from($this->newsRepository->getById($id))
            );
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}