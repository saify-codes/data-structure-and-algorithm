<?php

interface _Iterator
{
    public function hasNext(): bool;
    public function next(): mixed;
}

interface _Iterable
{
    public function getIterator(): _Iterator;
}


class _ArrayIterator implements _Iterator
{
    private $array;
    private $position;


    public function __construct(array $array) {
        $this->array = $array;
        $this->position = 0;
    }

    public function hasNext():bool
    {
        return $this->position < count($this->array);
    }

    public function next():mixed
    {
        return $this->array[$this->position++];
    }

}

class Song{

    public function __construct(public $name, public $artist) {}
    
}

class Playlist implements _Iterable{

    private $songs = [];

    public function add(Song $song){
        $this->songs[] = $song;
    }
    
    public function remove(Song $song){
        $this->songs = array_filter($this->songs, fn($target) => $song != $target);
    }

    public function getIterator(): _Iterator
    {
        return new _ArrayIterator($this->songs);
    }

}


$playlist = new Playlist();
$playlist->add(new Song("Often", "the weekend"));
$playlist->add(new Song("Blinding Lights", "The Weeknd"));
$playlist->add(new Song("Save Your Tears", "The Weeknd"));

$iterator = $playlist->getIterator();

while ($iterator->hasNext()) {
    $song = $iterator->next();
    echo "Playing: {$song->name} by {$song->artist}\n";
}