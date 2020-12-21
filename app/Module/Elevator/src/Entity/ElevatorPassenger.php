<?php

namespace Elevator\Entity;

use Elevator\Interfaces\ElevatorDirectionInterface;

/**
 * Class ElevatorPassenger
 *
 * @package Elevator\Entity
 */
class ElevatorPassenger implements ElevatorDirectionInterface
{
    /**
     * @var int
     */
    protected int $initialFloor;

    /**
     * @var string
     */
    protected string $selectedDirection;

    /**
     * @var int
     */
    protected int $targetFloor;

    /**
     * ElevatorPassenger constructor.
     *
     * @param int    $initialFloor
     * @param string $selectedDirection
     * @param int    $targetFloor
     */
    public function __construct(int $initialFloor, string $selectedDirection, int $targetFloor)
    {
        $this->initialFloor      = $initialFloor;
        $this->selectedDirection = $selectedDirection;
        $this->targetFloor       = $targetFloor;
    }

    /**
     * @return int
     */
    public function getinitialFloor(): int
    {
        return $this->initialFloor;
    }

    /**
     * @return string
     */
    public function getSelectedDirection(): string
    {
        return $this->selectedDirection;
    }

    /**
     * @return int
     */
    public function getTargetFloor(): int
    {
        return $this->targetFloor;
    }
}