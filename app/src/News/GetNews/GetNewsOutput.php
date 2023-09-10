<?php

namespace App\News\GetNews;

use App\News\News;

class GetNewsOutput
{
    public function __construct(
        public string $id = '',
        public string $text = '',
        public string $title = '',
    ) {
    }

    public static function from(News $news): self
    {
        return new self(
            $news->getId()->toRfc4122(),
            $news->getText(),
            $news->getTitle()
        );
    }
}