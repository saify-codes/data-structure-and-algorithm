<?php

class Memento{
    
    private $state;

    public function __construct(Player $player)
    {
        $this->state = clone $player;
    }

    public function getState(): Player
    {
        return $this->state;
    }
}

class Caretaker{

    private $mementos = [];
    private $originator;

    public function __construct(Player $originator)
    {
        $this->originator = $originator;
    }

    public function backup(){
        $this->mementos[] = $this->originator->save();
    }

    public function restore(){
        $memento = array_pop($this->mementos);
        if ($memento) {
            $this->originator->restore($memento);
        }
    }
    
}

class Player{

    private $speed;
    private $height;
    private $weight;
    private $bio;

    public function __construct(float $speed, float $height, float $weight, string $bio)
    {
        $this->speed = $speed;
        $this->height = $height;
        $this->weight = $weight;
        $this->bio = $bio;
    }

    public function getSpeed(): float
    {
        return $this->speed;
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setSpeed(float $speed): void
    {
        $this->speed = $speed;
    }

    public function setHeight(float $height): void
    {
        $this->height = $height;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    public function save(): Memento
    {
        return new Memento($this);
    }

    public function restore(Memento $memento): void
    {
        $state          = $memento->getState();
        $this->speed    = $state->getSpeed();
        $this->height   = $state->getHeight();
        $this->weight   = $state->getWeight();
        $this->bio      = $state->getBio();
    }

    public function __toString()
    {
        return sprintf("Player details: Speed: %.2f, Height: %.2f, Weight: %.2f, Bio: %s" . PHP_EOL, $this->speed, $this->height, $this->weight, $this->bio);
    }
}


$player     = new Player(36, 6, 65, "Name: ali, gender: male, cnic: 4240128978681");
$caretaker  = new Caretaker($player);

$caretaker->backup();
$player->setSpeed(40);
$player->setHeight(6.2);
$player->setWeight(70);

print $player;
$caretaker->restore();
print $player;

