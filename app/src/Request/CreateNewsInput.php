<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;

class CreateNewsInput
{
    #[NotBlank]
    public string $title;

    #[NotBlank]
    public string $text;
}