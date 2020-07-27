<?php

namespace Elevator\Logger;

/**
 * Class ConsoleLogger
 *
 * @package Elevator\Logger
 *
 */
class ConsoleLogger extends AbstractLogger
{
    /**
     * @param string $message
     */
    function log(string $message): void
    {
        echo $message . PHP_EOL;
        sleep(1);
    }
}