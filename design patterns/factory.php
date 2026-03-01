<?php
/**
 * Furniture example:
 * 1) Simple Factory
 * 2) Factory Method
 * 3) Abstract Factory
 *
 * Put this in any PHP file to understand the patterns.
 * In Laravel, you would split classes into app/ directories.
 */

/* =========================
   1) SIMPLE FACTORY
   ========================= */

interface SimpleFurniture
{
    public function name(): string;
}

class SimpleChair implements SimpleFurniture
{
    public function name(): string { return 'Chair'; }
}

class SimpleTable implements SimpleFurniture
{
    public function name(): string { return 'Table'; }
}

class SimpleFurnitureFactory
{
    public static function make(string $type): SimpleFurniture
    {
        $type = strtolower(trim($type));

        if ($type === 'chair') return new SimpleChair();
        if ($type === 'table') return new SimpleTable();

        throw new InvalidArgumentException("Unknown furniture type: {$type}");
    }
}

/* Usage */
$simple = SimpleFurnitureFactory::make('chair');
// echo $simple->name() . PHP_EOL;


/* =========================
   2) FACTORY METHOD
   ========================= */

interface FurnitureProduct
{
    public function label(): string;
}

class ChairProduct implements FurnitureProduct
{
    public function label(): string { return 'Chair'; }
}

class TableProduct implements FurnitureProduct
{
    public function label(): string { return 'Table'; }
}

abstract class FurnitureCreator
{
    abstract public function create(): FurnitureProduct;

    public function printLabel(): string
    {
        // shared logic can live here
        return $this->create()->label();
    }
}

class ChairCreator extends FurnitureCreator
{
    public function create(): FurnitureProduct
    {
        return new ChairProduct();
    }
}

class TableCreator extends FurnitureCreator
{
    public function create(): FurnitureProduct
    {
        return new TableProduct();
    }
}

/* Usage */
$creator = new ChairCreator();
// echo $creator->printLabel() . PHP_EOL;


/* =========================
   3) ABSTRACT FACTORY
   ========================= */

interface Chair
{
    public function sitOn(): string;
}

interface Table
{
    public function dineOn(): string;
}

interface FurnitureFactory
{
    public function createChair(): Chair;
    public function createTable(): Table;
}

/* Modern family */

class ModernChair implements Chair
{
    public function sitOn(): string { return 'Sitting on a modern chair'; }
}

class ModernTable implements Table
{
    public function dineOn(): string { return 'Dining on a modern table'; }
}

class ModernFurnitureFactory implements FurnitureFactory
{
    public function createChair(): Chair { return new ModernChair(); }
    public function createTable(): Table { return new ModernTable(); }
}

/* Victorian family */

class VictorianChair implements Chair
{
    public function sitOn(): string { return 'Sitting on a victorian chair'; }
}

class VictorianTable implements Table
{
    public function dineOn(): string { return 'Dining on a victorian table'; }
}

class VictorianFurnitureFactory implements FurnitureFactory
{
    public function createChair(): Chair { return new VictorianChair(); }
    public function createTable(): Table { return new VictorianTable(); }
}

/* Usage */
function client(FurnitureFactory $factory): void
{
    $chair = $factory->createChair();
    $table = $factory->createTable();

    echo $chair->sitOn() . PHP_EOL;
    echo $table->dineOn() . PHP_EOL;
}

/* Run all demos */
echo "Simple Factory: " . SimpleFurnitureFactory::make('table')->name() . PHP_EOL;

echo "Factory Method: " . (new TableCreator())->printLabel() . PHP_EOL;

echo "Abstract Factory (Modern):" . PHP_EOL;
client(new ModernFurnitureFactory());

echo "Abstract Factory (Victorian):" . PHP_EOL;
client(new VictorianFurnitureFactory());