<?php

namespace Elevator\Strategy;

use Elevator\Container\MovementContainer;
use Elevator\Service\AbstractElevator;

/**
 * Interface ElevatorMovementStrategyInterface
 *
 * @package Elevator\Strategy
 */
interface ElevatorMovementStrategyInterface
{
    /**
     * @param AbstractElevator $elevator
     *
     * @return MovementContainer
     */
    public function calculateMovementPlan(AbstractElevator $elevator): MovementContainer;
}