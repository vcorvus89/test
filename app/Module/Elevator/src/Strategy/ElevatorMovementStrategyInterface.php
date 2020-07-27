<?php

namespace Elevator\Strategy;

use Elevator\Service\AbstractElevator;
use Elevator\Container\MovementContainer;

/**
 * Interface ElevatorMovementStrategyInterface
 *
 * @package Elevator\Strategy
 */
interface ElevatorMovementStrategyInterface
{
    /**
     * @param \Elevator\Service\AbstractElevator $elevator
     *
     * @return \Elevator\Container\MovementContainer
     */
    public function calculateMovementPlan(AbstractElevator $elevator): MovementContainer;
}