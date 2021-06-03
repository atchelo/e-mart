<?php

namespace Yoeunes\Notify;

use RuntimeException;
use Yoeunes\Notify\Notifiers\NotifierInterface;

class NotifierFactory
{
    /**
     * @param array $config
     *
     * @return NotifierInterface
     */
    public static function make(array $config): NotifierInterface
    {
        $driver = $config['default'];

        if (!isset($config[$driver])) {
            throw new RuntimeException('Unknown "'.$driver.'" notification driver.');
        }

        $class = $config[$driver]['class'];

        if (!class_exists($class)) {
            throw new RuntimeException('class "'.$class.'" does not exists.');
        }

        return new $class($config[$driver]);
    }
}
