<?php

namespace PTH;

/**
 * Class Singleton
 */
class Singleton
{
    /**
     * Get instance
     *
     * @return static
     */
    final static public function getInstance()
    {
        static $instance = null;
        return $instance ?: $instance = new static;
    }

    /**
     * Magic method prevent cloning of the instance of the Singleton instance
     */
    final private function __clone()
    {
    }

    /**
     * Magic method prevent unserializing of the Singleton instance.
     */
    final private function __wakeup()
    {
    }
}