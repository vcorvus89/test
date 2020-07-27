<?php

namespace Elevator\Logger;

/**
 * Class AbstractLogger
 *
 * @package Elevator\Logger
 */
abstract class AbstractLogger
{
    /**
     * @param string $message
     */
    abstract function log(string $message): void;
}