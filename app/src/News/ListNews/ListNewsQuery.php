<?php

namespace App\News\ListNews;

use App\News\NewsRepository;

class ListNewsQuery
{
    public function __construct(private NewsRepository $newsRepository)
    {
    }

    public function __invoke(?string $sortBy, ?string $order)
    {
       $list =  $this->newsRepository->getAll();

       if ($sortBy && $order) {
           $list = $list->sort($sortBy, $order);
       }

       return $list;
    }
}