<?php

class Singleton{

    private static $instance;

    private function __construct() {
    }

    public static function getInstance(){

        if (is_null(self::$instance)) {
            print "Initialized";
            return self::$instance = new self();
        }

        return self::$instance;

    }
}

$o = Singleton::getInstance();
$o = Singleton::getInstance();
$o = Singleton::getInstance();
$o = Singleton::getInstance();
$o = Singleton::getInstance();