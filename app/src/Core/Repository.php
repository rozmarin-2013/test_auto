<?php

namespace App\Core;

class Repository
{
    public function __construct(
        protected DataProvider $dataProvider
    ) {}
}