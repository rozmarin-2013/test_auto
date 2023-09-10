<?php

namespace App\News;

use Symfony\Component\Uid\Uuid;

class News
{
    private Uuid $id;
    private \DateTime $createdAt;

    public function __construct(
        private string $title = '',
        private string $text = ''
    ) {
        $this->id = Uuid::v4();
        $this->createdAt = new \DateTime();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}