<?php

namespace App\News\CreateNews;

use App\News\News;
use App\News\NewsRepository;
use App\Request\CreateNewsInput;
use Symfony\Component\Uid\Uuid;

class CreateNewsCommand
{
    public function __construct(
        private NewsRepository $newsRepository
    )
    {

    }

    /**
     * @throws \Exception
     */
    public function execute(CreateNewsInput $input): Uuid
    {
        $news = new News(
            $input->title,
            $input->text
        );

        $this->newsRepository->save($news);

        return $news->getId();
    }
}