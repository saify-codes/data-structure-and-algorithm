<?php

interface FileSystem{

    public function getSize();
    public function getName();

}

class File implements FileSystem{
    private $name;
    private $size;

    public function __construct(string $name, int $size)
    {
        $this->name = $name;
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getName()
    {
        return $this->name;
    }
}

class Dir implements FileSystem{
    private $name;
    private $files = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function add(FileSystem $file)
    {
        $this->files[] = $file;
    }

    public function getSize()
    {
        $size = 0;
        foreach ($this->files as $file) {
            $size += $file->getSize();
        }
        return $size;
    }

    public function getName()
    {
        return $this->name;
    }
}

$root = new Dir("root");
$root->add(new File("file1.txt", 100));
$root->add(new File("file2.txt", 200));

$documents = new Dir("documents");
$documents->add(new File("document1.txt", 300));
$documents->add(new File("document2.txt", 400));

$root->add($documents);

echo $root->getSize ();