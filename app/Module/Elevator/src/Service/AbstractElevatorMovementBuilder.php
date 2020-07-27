<?php

namespace Elevator\Service;

use Elevator\Interfaces\ElevatorDirectionInterface;
use Elevator\Strategy\ElevatorMovementStrategyInterface;
use Elevator\Container\MovementContainer;

/**
 * Class AbstractElevatorMovementBuilder
 *
 * @package Elevator\Service
 */
abstract class AbstractElevatorMovementBuilder implements ElevatorDirectionInterface
{
    /**
     * @var \Elevator\Strategy\ElevatorMovementStrategyInterface
     */
    protected $movementStrategy;

    /**
     * AbstractElevatorMovementBuilder constructor.
     *
     * @param \Elevator\Strategy\ElevatorMovementStrategyInterface $movementStrategy
     */
    public function __construct(ElevatorMovementStrategyInterface $movementStrategy)
    {
        $this->movementStrategy = $movementStrategy;
    }

    /**
     * @return \Elevator\Strategy\ElevatorMovementStrategyInterface
     */
    public function getMovementStrategy(): ElevatorMovementStrategyInterface
    {
        return $this->movementStrategy;
    }

    /**
     * @param \Elevator\Strategy\ElevatorMovementStrategyInterface $movementStrategy
     */
    public function setMovementStrategy(ElevatorMovementStrategyInterface $movementStrategy): void
    {
        $this->movementStrategy = $movementStrategy;
    }

    /**
     * @param \Elevator\Service\AbstractElevator $elevator
     *
     * @return \Elevator\Container\MovementContainer
     */
    public function getMovementPlan(AbstractElevator $elevator): MovementContainer
    {
        // В случае необходимости использования разных алгоритмов движения в данном методе необходимо будет реализовать
        // переключатель выбора алгоритма движения.
        return $this->movementStrategy->calculateMovementPlan($elevator);
    }
}