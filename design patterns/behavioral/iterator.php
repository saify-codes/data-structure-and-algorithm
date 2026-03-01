<?php

/*
|--------------------------------------------------------------------------
| 1. Iterator Interface
|--------------------------------------------------------------------------
*/

interface MyIterator
{
    public function hasNext(): bool;
    public function next(): mixed;
}

/*
|--------------------------------------------------------------------------
| 2. Collection Interface
|--------------------------------------------------------------------------
*/

interface MyCollection
{
    public function createIterator(): MyIterator;
}

/*
|--------------------------------------------------------------------------
| 3. Concrete Iterator
|--------------------------------------------------------------------------
*/

class NameIterator implements MyIterator
{
    private int $position = 0;

    public function __construct(private array $items) {}

    public function hasNext(): bool
    {
        return $this->position < count($this->items);
    }

    public function next(): mixed
    {
        return $this->items[$this->position++];
    }
}

/*
|--------------------------------------------------------------------------
| 4. Concrete Collection
|--------------------------------------------------------------------------
*/

class NameCollection implements MyCollection
{
    private array $names = [];

    public function add(string $name): void
    {
        $this->names[] = $name;
    }

    public function createIterator(): MyIterator
    {
        return new NameIterator($this->names);
    }
}

/*
|--------------------------------------------------------------------------
| 5. Usage
|--------------------------------------------------------------------------
*/

$collection = new NameCollection();
$collection->add("Ali");
$collection->add("Ahmed");
$collection->add("Sara");

$iterator = $collection->createIterator();

while ($iterator->hasNext()) {
    echo $iterator->next() . PHP_EOL;
}