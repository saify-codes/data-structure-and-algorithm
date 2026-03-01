<?php

// 1. _Iterator Interface
interface _Iterator
{
    public function hasNext(): bool;
    public function next();
}

// 2. Aggregate Interface
interface _Iterable
{
    public function createIterator(): _Iterator;
}

// 3. Concrete Aggregate
class BookCollection implements _Iterable
{
    private array $books = [];

    public function add(string $book): void
    {
        $this->books[] = $book;
    }

    public function getItems(): array
    {
        return $this->books;
    }

    public function createIterator(): _Iterator
    {
        return new BookIterator($this);
    }
}

// 4. Concrete _Iterator
class BookIterator implements _Iterator
{
    private array $items;
    private int $position = 0;

    public function __construct(BookCollection $collection)
    {
        $this->items = $collection->getItems();
    }

    public function hasNext(): bool
    {
        return $this->position < count($this->items);
    }

    public function next()
    {
        return $this->items[$this->position++];
    }
}


// 5. Client Code

$collection = new BookCollection();
$collection->add("Clean Code");
$collection->add("Design Patterns");
$collection->add("Refactoring");

$iterator = $collection->createIterator();

while ($iterator->hasNext()) {
    echo $iterator->next() . PHP_EOL;
}
