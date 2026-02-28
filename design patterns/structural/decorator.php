<?php

abstract class Room {
    protected $name;
    protected $cnic;

    public function __construct($name, $cnic)
    {
        $this->name = $name;
        $this->cnic = $cnic;
    }

    abstract public function getDescription();
    abstract public function getCost();
}

class BasicRoom extends Room {

    public function getDescription()
    {
        return "A simple room";
    }

    public function getCost()
    {
        return 100;
    }
}

abstract class RoomDecorator extends Room {
    protected $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }
}

class Wifi extends RoomDecorator {

    public function getDescription()
    {
        return $this->room->getDescription() . " with Wifi";
    }

    public function getCost()
    {
        return $this->room->getCost() + 20;
    }
}

class Seaview extends RoomDecorator {

    public function getDescription()
    {
        return $this->room->getDescription() . " with Seaview";
    }

    public function getCost()
    {
        return $this->room->getCost() + 50;
    }
}

class Russian extends RoomDecorator {

    public function getDescription()
    {
        return $this->room->getDescription() . " with Russian";
    }

    public function getCost()
    {
        return $this->room->getCost() + 6000;
    }
}

$room = new BasicRoom("John Doe", "12345");
$room = new Wifi($room);
$room = new Seaview($room);
$room = new Russian($room);

print $room->getDescription() . " costs $" . $room->getCost() . PHP_EOL;

?>