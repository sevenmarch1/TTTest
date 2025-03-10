<?php

/**
 * - Полуение экземпляра класса через статический метод getInstance()
 */

namespace TT\Traits;


trait Singletone
{

    /**
     * @var static[]
     */
    private static $instance = [];


    protected function __construct()
    {
    }


    /**
     * @return static 
     */
    final static function getInstance(): self
    {
        $class = get_called_class();
       
        if (!isset(self::$instance[$class])) {
            self::$instance[$class] = new static();
        }
        return self::$instance[$class];
    }
}
