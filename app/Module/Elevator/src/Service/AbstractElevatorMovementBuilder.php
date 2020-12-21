<?php

namespace Elevator\Service;

use Elevator\Container\MovementContainer;
use Elevator\Interfaces\ElevatorDirectionInterface;
use Elevator\Strategy\ElevatorMovementStrategyInterface;

/**
 * Class AbstractElevatorMovementBuilder
 *
 * @package Elevator\Service
 */
abstract class AbstractElevatorMovementBuilder implements ElevatorDirectionInterface
{
    /**
     * @var ElevatorMovementStrategyInterface
     */
    protected $movementStrategy;

    /**
     * AbstractElevatorMovementBuilder constructor.
     *
     * @param ElevatorMovementStrategyInterface $movementStrategy
     */
    public function __construct(ElevatorMovementStrategyInterface $movementStrategy)
    {
        $this->movementStrategy = $movementStrategy;
    }

    /**
     * @return ElevatorMovementStrategyInterface
     */
    public function getMovementStrategy(): ElevatorMovementStrategyInterface
    {
        return $this->movementStrategy;
    }

    /**
     * @param ElevatorMovementStrategyInterface $movementStrategy
     */
    public function setMovementStrategy(ElevatorMovementStrategyInterface $movementStrategy): void
    {
        $this->movementStrategy = $movementStrategy;
    }

    /**
     * @param AbstractElevator $elevator
     *
     * @return MovementContainer
     */
    public function getMovementPlan(AbstractElevator $elevator): MovementContainer
    {
        // В случае необходимости использования разных алгоритмов движения в данном методе необходимо будет реализовать
        // переключатель выбора алгоритма движения.
        return $this->movementStrategy->calculateMovementPlan($elevator);
    }
}