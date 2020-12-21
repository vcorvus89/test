<?php

namespace Elevator\Strategy;

use Elevator\Container\MovementContainer;
use Elevator\Entity\ElevatorPassenger;
use Elevator\Service\AbstractElevator;

/**
 * Class SimpleElevatorMovementStrategy
 *
 * @package Elevator\Strategy
 */
class SimpleElevatorMovementStrategy implements ElevatorMovementStrategyInterface
{
    /**
     * @param AbstractElevator $elevator
     *
     * @return MovementContainer
     *
     * Так как не указано время вызова лифта каждым из пассажиров и все инструкции поступают заранее -
     * параметр лифта "speed" не имеет смысла и считаем, что лифт был вызван одновременно всеми пассажирами.
     */
    public function calculateMovementPlan(AbstractElevator $elevator): MovementContainer
    {
        [$passengersUp, $passengersDown] = $this->splitStepsByDirections($elevator->getPassengers());

        $movementContainer = new MovementContainer();

        $this->populateFloorSequenceWithUpSteps($movementContainer, $passengersUp);
        $this->populateFloorSequenceWithDownSteps($movementContainer, $passengersDown);

        $movementContainer->lock();

        return $movementContainer;
    }

    /**
     * @param $passengers
     *
     * @return array[]
     */
    protected function splitStepsByDirections($passengers): array
    {
        $passengersUp   = [];
        $passengersDown = [];

        foreach ($passengers as $passenger) {
            if ($passenger->getSelectedDirection() === ElevatorPassenger::DIRECTION_UP) {
                $passengersUp[] = $passenger;
            }

            if ($passenger->getSelectedDirection() === ElevatorPassenger::DIRECTION_DOWN) {
                $passengersDown[] = $passenger;
            }
        }

        return [$passengersUp, $passengersDown];
    }

    /**
     * @param MovementContainer                     $movementContainer
     * @param                                       $passengers
     */
    protected function populateFloorSequenceWithUpSteps(MovementContainer $movementContainer, $passengers): void
    {
        usort(
            $passengers,
            function (ElevatorPassenger $a, ElevatorPassenger $b) {
                return $a->getInitialFloor() <=> $b->getInitialFloor();
            }
        );

        foreach ($passengers as $passenger) {
            $movementContainer->addMovement($passenger->getInitialFloor());
        }

        usort(
            $passengers,
            function (ElevatorPassenger $a, ElevatorPassenger $b) {
                return -($a->getTargetFloor() <=> $b->getTargetFloor());
            }
        );

        foreach ($passengers as $passenger) {
            $movementContainer->addMovement($passenger->getTargetFloor());
        }
    }

    /**
     * @param MovementContainer                     $movementContainer
     * @param                                       $passengers
     */
    protected function populateFloorSequenceWithDownSteps(MovementContainer $movementContainer, $passengers): void
    {
        usort(
            $passengers,
            function (ElevatorPassenger $a, ElevatorPassenger $b) {
                return -($a->getInitialFloor() <=> $b->getInitialFloor());
            }
        );

        foreach ($passengers as $passenger) {
            $movementContainer->addMovement($passenger->getInitialFloor());
        }

        usort(
            $passengers,
            function (ElevatorPassenger $a, ElevatorPassenger $b) {
                return -($a->getTargetFloor() <=> $b->getTargetFloor());
            }
        );

        foreach ($passengers as $passenger) {
            $movementContainer->addMovement($passenger->getTargetFloor());
        }
    }
}