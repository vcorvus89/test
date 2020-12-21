<?php

use Elevator\Entity\ElevatorPassenger;
use Elevator\Factory\ElevatorFactory;
use Elevator\Logger\ConsoleLogger;
use Elevator\Service\Elevator;
use Elevator\Service\ElevatorMovementBuilder;
use Elevator\Strategy\SimpleElevatorMovementStrategy;

require_once __DIR__ . '/../vendor/autoload.php';

$elevatorFactory = new ElevatorFactory();
$elevatorFactory->setElevatorClass(Elevator::class)
                ->setElevatorMovementBuilderClass(ElevatorMovementBuilder::class)
                ->setElevatorMovementStrategyClass(SimpleElevatorMovementStrategy::class)
                ->setLoggerClass(ConsoleLogger::class);


$elevator = $elevatorFactory->build();

$passenger1 = new ElevatorPassenger(1, ElevatorPassenger::DIRECTION_UP, 4);
$passenger2 = new ElevatorPassenger(3, ElevatorPassenger::DIRECTION_DOWN, 2);
$passenger3 = new ElevatorPassenger(4, ElevatorPassenger::DIRECTION_DOWN, 1);

$elevator->addPassenger($passenger1)
         ->addPassenger($passenger2)
         ->addPassenger($passenger3);

$elevator->run();
