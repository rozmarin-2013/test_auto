<?php

namespace App\Core;

use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractCollection extends ArrayCollection
{
    abstract protected function getType(): string;

    public function set(string|int $key, mixed $value): void
    {
        if (!$value instanceof $this->type) {
            throw new \Exception(
                sprintf(
                    'Type of elemet must be type %s, but %s given ',
                    $this->type,
                    get_class($value)
                )
            );
        }

        parent::add($value);
    }

    /**
     * @throws \Exception
     */
    public function add(mixed $element): void
    {
        if (!$element instanceof $this->type) {
            throw new \Exception(
                sprintf(
                    'Type of elemet must be type %s, but %s given ',
                    $this->type,
                    get_class($element)
                )
            );
        }

        parent::add($element);
    }

    public function sort(string $field, string $order): static
    {
        if ($order === 'ASC') {
            return $this->ascSort($field);
        } else {
            return $this->descSort($field);
        }
    }

    protected function ascSort($field): static
    {
        $sortArray = $this->toArray();

        uasort($sortArray, function ($first, $second) use ($field): int {
            return $first->{'get' . $field}() <=> $second->{'get' . $field}();
        });

        return new static($sortArray);
    }

    protected function descSort($field): static
    {
        return new static(array_reverse($this->ascSort($field)->toArray()));
    }
}