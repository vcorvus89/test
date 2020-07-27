<?php

namespace Elevator\Factory;

use Elevator\Service\Elevator;

/**
 * Class ElevatorFactory
 *
 * @package Elevator\Factory
 */
class ElevatorFactory
{
    /**
     * @var string
     */
    protected $elevatorClass;

    /**
     * @var string
     */
    protected $elevatorMovementBuilderClass;

    /**
     * @var string
     */
    protected $elevatorMovementStrategyClass;

    /**
     * @var string
     */
    protected $loggerClass;

    /**
     * @return mixed
     */
    public function getElevatorClass()
    {
        return $this->elevatorClass;
    }

    /**
     * @param $elevatorClass
     *
     * @return $this
     */
    public function setElevatorClass($elevatorClass): self
    {
        $this->elevatorClass = $elevatorClass;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getElevatorMovementBuilderClass()
    {
        return $this->elevatorMovementBuilderClass;
    }

    /**
     * @param $elevatorMovementBuilderClass
     *
     * @return $this
     */
    public function setElevatorMovementBuilderClass($elevatorMovementBuilderClass): self
    {
        $this->elevatorMovementBuilderClass = $elevatorMovementBuilderClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getElevatorMovementStrategyClass(): string
    {
        return $this->elevatorMovementStrategyClass;
    }

    /**
     * @param string $elevatorMovementStrategyClass
     *
     * @return $this
     */
    public function setElevatorMovementStrategyClass(string $elevatorMovementStrategyClass): self
    {
        $this->elevatorMovementStrategyClass = $elevatorMovementStrategyClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getLoggerClass(): string
    {
        return $this->loggerClass;
    }

    /**
     * @param string $loggerClass
     *
     * @return $this
     */
    public function setLoggerClass(string $loggerClass): self
    {
        $this->loggerClass = $loggerClass;

        return $this;
    }

    /**
     * @return \Elevator\Service\Elevator
     */
    public function build(): Elevator
    {
        $elevatorMovementStrategy = new $this->elevatorMovementStrategyClass();
        $elevatorMovementBuilder  = new $this->elevatorMovementBuilderClass($elevatorMovementStrategy);
        $elevator                 = new $this->elevatorClass($elevatorMovementBuilder, new $this->loggerClass());

        return $elevator;
    }
}