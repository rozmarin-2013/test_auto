<?php

namespace App\News;

use App\Core\AbstractCollection;

class NewsCollection extends AbstractCollection
{
    final public function __construct(array $elements = [])
    {
        parent::__construct($elements);

        $this->type = $this->getType();
    }
    protected function getType(): string
    {
        return News::class;
    }
}