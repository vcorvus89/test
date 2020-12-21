<?php

namespace Elevator\Container;

use Iterator;
use RuntimeException;

/**
 * Class MovementContainer
 *
 * @package Elevator\Entity
 */
class MovementContainer implements Iterator
{
    /**
     * @var int
     */
    protected int $position = 0;

    /**
     * @var bool
     */
    protected bool $isLocked = false;

    /**
     * @var array
     */
    protected $movements = [];

    /**
     * @param int $nextFloor
     *
     * @return $this
     */
    public function addMovement(int $nextFloor): self
    {
        if ($this->isLocked) {
            throw new RuntimeException(sprintf('%s is locked for adding new elements', __CLASS__));
        }

        if (end($this->movements) !== $nextFloor) {
            $this->movements[] = $nextFloor;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function lock(): self
    {
        $this->isLocked = true;

        return $this;
    }

    /**
     * @return int
     */
    public function current(): int
    {
        return $this->movements[$this->position];
    }

    /**
     * @return int|null
     */
    public function next(): ?int
    {
        return $this->movements[++$this->position];
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->movements[$this->position]);
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->position = 0;
    }
}