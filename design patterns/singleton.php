<?php

class Singleton{

    private static $instance;

    private function __construct()
    {
        echo "Singleton instance created\n";
    }

    public static function getInstance(){

        if(is_null(self::$instance)){
            return self::$instance = new Singleton();
        }

        return self::$instance;
    }

}



$o = Singleton::getInstance();
$o = Singleton::getInstance();
$o = Singleton::getInstance();
$o = Singleton::getInstance();
