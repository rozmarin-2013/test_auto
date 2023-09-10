<?php

namespace App\News\ListNews;

use App\News\GetNews\GetNewsOutput;
use App\News\News;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsListAction
{
    public function __construct(
        private ListNewsQuery $listNewsQuery
    )
    {
    }

    #[Route('/news', name: 'api_list_news', methods: 'GET')]
    public function __invoke(Request $request)
    {
        try {
            $list = ($this->listNewsQuery)(
                $request->get('sortBy'),
                $request->get('order')
            );

            return new JsonResponse($list->map(fn(News $item) => GetNewsOutput::from($item))->toArray());
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }
}