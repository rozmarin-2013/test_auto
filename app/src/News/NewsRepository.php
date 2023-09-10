<?php

namespace App\News;

use App\Core\DataProvider;
use App\Core\Repository;
use Symfony\Component\Uid\Uuid;

class NewsRepository extends Repository
{
    CONST FILE_NAME = 'news.json';

    /**
     * @throws \Exception
     */
    public function getAll(): NewsCollection
    {
        return new NewsCollection(
            $this->dataProvider->get(
                self::FILE_NAME,
                News::class . '[]'
            ),
        );
    }

    /**
     * @throws \Exception
     */
    public function save(News $news)
    {
        $this->dataProvider->persist(self::FILE_NAME, $news);
    }

    public function getById(string $uuid)
    {
        $collection = $this->getAll();
        $result = $collection->filter( function (News $news) use ($uuid) {
            return $news->getId()->compare(Uuid::fromString($uuid)) === 0;
        });

        return $result->first();
    }
}