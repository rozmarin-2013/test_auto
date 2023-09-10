<?php

namespace App\Core;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class DataProvider implements DataProviderInterface
{
    const STORAGE_DIR = '../resources/';

    public function __construct(
        private Filesystem $filesystem,
        private SerializerInterface $serializer
    )
    {

    }

    /**
     * @throws \Exception
     */
    public function persist(string $fileName, object $content): void
    {
        if (!$this->filesystem->exists(self::STORAGE_DIR . $fileName)) {
            throw new \Exception(sprintf('File %s dont exist', $fileName));
        }

        $fileContent = file_get_contents(self::STORAGE_DIR. $fileName);

        $fileContent = ($fileContent)
            ? new ArrayCollection($this->serializer->deserialize(
                $fileContent,
                $content::class . '[]',
                'json'
            )
            )
            : new ArrayCollection([]);

        $fileContent->add($content);

        file_put_contents(
            '../resources/' . $fileName ,
            $this->serializer->serialize($fileContent, 'json')
        );
    }

    public function get(string $fileName, string $type): array
    {
        if (!$this->filesystem->exists(self::STORAGE_DIR . $fileName)) {
            throw new \Exception(sprintf('File %s dont exist'), $fileName);
        }
        $fileContent = file_get_contents(self::STORAGE_DIR . $fileName);

        return ($fileContent)
            ? $this->serializer->deserialize(
                $fileContent,
                $type,
                'json'
            )
            : [];
    }
}