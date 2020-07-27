<?php

namespace Elevator\Service;

use Elevator\Entity\ElevatorPassenger;

/**
 * Class AbstractElevator
 *
 * @package Elevator\Service
 */
abstract class AbstractElevator
{
    const CURRENT_STATE_STOP       = 'stop';
    const CURRENT_STATE_GOING_UP   = 'going_up';
    const CURRENT_STATE_GOING_DOWN = 'going_down';

    /**
     * @var string
     */
    protected string $currentState;

    /**
     * @var int
     */
    protected int $initialFloor = 1;

    /**
     * @var int
     */
    protected int $minFloor = 1;

    /**
     * @var int
     */
    protected int $maxFloor = 4;

    /**
     * @var int
     */
    protected int $currentFloor = 1;

    /**
     * @var int
     */
    protected int $speed = 1;

    /**
     * @var array
     */
    protected $passengers = [];

    /**
     * @var array
     */
    protected $passengersInside = [];

    /**
     * @var \Elevator\Service\ElevatorMovementBuilder
     */
    protected $movementBuilder;

    /**
     * @var \Elevator\Logger\AbstractLogger
     */
    protected $logger;

    /**
     * AbstractElevator constructor.
     *
     * @param $movementBuilder
     * @param $logger
     */
    public function __construct($movementBuilder, $logger)
    {
        $this->movementBuilder = $movementBuilder;
        $this->logger          = $logger;
    }

    public function run()
    {
        $movementPlan = $this->movementBuilder->getMovementPlan($this);

        foreach ($movementPlan as $floor) {
            $this->goToFloor($floor);
            $this->releasePassengers($floor);
            $this->letPassengers($floor);
        }
    }

    /**
     * @return string
     */
    public function getCurrentState(): string
    {
        return $this->currentState;
    }

    /**
     * @param $currentState
     *
     * @return $this
     */
    public function setCurrentState($currentState): self
    {
        $this->currentState = $currentState;

        return $this;
    }

    /**
     * @return int
     */
    public function getInitialFloor(): int
    {
        return $this->initialFloor;
    }

    /**
     * @param int $initialFloor
     *
     * @return $this
     */
    public function setInitialFloor(int $initialFloor): self
    {
        $this->initialFloor = $initialFloor;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinFloor(): int
    {
        return $this->minFloor;
    }

    /**
     * @param int $minFloor
     *
     * @return $this
     */
    public function setMinFloor(int $minFloor): self
    {
        $this->minFloor = $minFloor;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxFloor(): int
    {
        return $this->maxFloor;
    }

    /**
     * @param int $maxFloor
     *
     * @return $this
     */
    public function setMaxFloor(int $maxFloor): self
    {
        $this->maxFloor = $maxFloor;

        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentFloor(): int
    {
        return $this->currentFloor;
    }

    /**
     * @param int $currentFloor
     *
     * @return $this
     */
    public function setCurrentFloor(int $currentFloor): self
    {
        $this->currentFloor = $currentFloor;

        return $this;
    }

    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->speed;
    }

    /**
     * @param int $speed
     *
     * @return $this
     */
    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * @param $passenger
     *
     * @return $this
     */
    public function addPassenger(ElevatorPassenger $passenger): self
    {
        $this->passengers[] = $passenger;

        return $this;
    }

    /**
     * @return array
     */
    public function getPassengers(): array
    {
        return $this->passengers;
    }

    /**
     * @param $floor
     */
    protected function releasePassengers($floor): void
    {
        $releasedPassengersCount = 0;

        /** @var ElevatorPassenger $passenger */
        foreach ($this->passengersInside as $key => $passenger) {
            if ($passenger->getTargetFloor() === $floor) {
                unset($this->passengersInside[$key]);
                ++$releasedPassengersCount;
            }
        }

        $this->logger->log(
            sprintf(
                '%d %s released on the %d floor',
                $releasedPassengersCount,
                $releasedPassengersCount > 1 || $releasedPassengersCount === 0 ? 'passengers' : 'passenger',
                $this->getCurrentFloor()
            )
        );
    }

    /**
     * @param $floor
     */
    protected function letPassengers($floor): void
    {
        $enteredPassengersCount = 0;

        /** @var ElevatorPassenger $passenger */
        foreach ($this->passengers as $key => $passenger) {
            if ($passenger->getinitialFloor() === $floor) {
                $this->passengersInside[] = $passenger;
                unset($this->passengers[$key]);
                ++$enteredPassengersCount;
            }
        }

        $this->logger->log(
            sprintf(
                '%d %s entered on the %d floor',
                $enteredPassengersCount,
                $enteredPassengersCount > 1 || $enteredPassengersCount === 0 ? 'passengers' : 'passenger',
                $this->getCurrentFloor()
            )
        );
    }

    /**
     * @param int $targetFloor
     *
     * @return void
     */
    protected function goToFloor(int $targetFloor): void
    {
        if ($targetFloor !== $this->getCurrentFloor()) {
            if ($targetFloor > $this->getCurrentFloor()) {
                $this->goUp($targetFloor);
            }

            if ($targetFloor < $this->getCurrentFloor()) {
                $this->goDown($targetFloor);
            }
        
            $this->stop();
        }
    }

    /**
     * @param int $targetFloor
     *
     * @return void
     */
    protected function goUp(int $targetFloor = 1): void
    {
        if ($targetFloor <= $this->getMaxFloor()) {
            $this->logger->log(sprintf('The elevator is going up on the %d floor', $targetFloor));
            $this->currentState = self::CURRENT_STATE_GOING_UP;
            $this->setCurrentFloor($targetFloor);
        }
    }

    /**
     * @param int $targetFloor
     *
     * @return void
     */
    protected function goDown(int $targetFloor = 1): void
    {
        if ($targetFloor >= $this->getMinFloor()) {
            $this->logger->log(sprintf('The elevator is going down on the %d floor', $targetFloor));
            $this->currentState = self::CURRENT_STATE_GOING_DOWN;
            $this->setCurrentFloor($targetFloor);
        }
    }

    /**
     * @return void
     */
    protected function stop(): void
    {
        $this->logger->log(sprintf('The elevator is stopping on the %d floor', $this->getCurrentFloor()));
        $this->currentState = self::CURRENT_STATE_STOP;
        $this->logger->log(sprintf('The elevator stopped on the %d floor', $this->getCurrentFloor()));
    }
}