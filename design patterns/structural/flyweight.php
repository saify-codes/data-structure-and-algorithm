<?php

ini_set('memory_limit', -1);
$totalEnemies = 500000;

function formatBytes($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;

    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }

    return round($bytes, 2) . ' ' . $units[$i];
}

class Orc{
    
    public string $type;
    public int $health;
    public int $attack;
    public int $defense;
    public float $speed;
    public string $weapon;
    public string $armor;
    public array $abilities;
    public string $texture;
    public string $model;
    public string $aiType;
    public int $visionRange;
    public int $stamina;
    public string $soundEffect;
    public string $spawnZone;
    public string $lore;

    public function __construct($type)
    {
        $this->type = $type;
        $this->health = 100;
        $this->attack = 25;
        $this->defense = 15;
        $this->speed = 1.5;
        $this->weapon = "Sword";
        $this->armor = "Steel Armor";
        $this->abilities = array_fill(0, 50, "Skill_" . $type);
        $this->texture = str_repeat("TEXTURE_" . $type, 50);
        $this->model = str_repeat("MODEL_" . $type, 50);
        $this->aiType = "Aggressive";
        $this->visionRange = 300;
        $this->stamina = 200;
        $this->soundEffect = str_repeat("ROAR_" . $type, 30);
        $this->spawnZone = "Dungeon";
        $this->lore = str_repeat("Ancient warrior from dark lands. ", 20);
    }
   
}

class Factory{

    private static $types = [];

    static function getOrc($type){

        if(!isset(self::$types[$type])){
            self::$types[$type] = new Orc($type);
        }

        return self::$types[$type];
    }


}

class Enemy{

    public $x;
    public $y;
    public $state;
    public function __construct($type)
    {
        $this->x = rand(0, 1000);
        $this->y = rand(0, 1000);
        $this->state = new Orc($type);
    }

}

class EnemyFlyweight {
    public $x;
    public $y;
    public $state;
    public function __construct($type)
    {
        $this->x = rand(0, 1000);
        $this->y = rand(0, 1000);
        $this->state = Factory::getOrc($type);
    }
}

/**
 * =========================
 * Normal Approach
 * =========================
 */

$enemies = [];
$start   = memory_get_usage(true);
printf("Testing normal approach\n");
printf("Spawning %s enemies...\n", number_format($totalEnemies));

for ($i=0; $i < $totalEnemies; $i++) 
    $enemies[] = new Enemy(["rock", "fire", "ice"][$i % 3]);

printf("MEMORY USED: %s \n\n", formatBytes(memory_get_usage(true) - $start));


/**
 * =========================
 *  Flyweight Approach
 * =========================
 */

$enemies  = [];
$start    = memory_get_usage(true);
printf("Testing flyweight approach\n");
printf("Spawning %s enemies...\n", number_format($totalEnemies));

for ($i=0; $i < $totalEnemies; $i++) 
    $enemies[] = new EnemyFlyweight(["rock", "fire", "ice"][$i % 3]);

printf("MEMORY USED: %s \n\n", formatBytes(memory_get_usage(true) - $start));

