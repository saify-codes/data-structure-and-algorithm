<?php

/**
 * PROTOTYPE PATTERN
 * 
 * The Prototype pattern is a creational design pattern that lets you copy 
 * existing objects without making your code dependent on their classes.
 */

/**
 * PHP has built-in support for cloning. The `__clone` magic method allows 
 * customizing the cloning process.
 */
class Page
{
    private $title;
    private $body;
    private $author;
    private $comments = [];
    private $date;

    public function __construct(string $title, string $body, Author $author)
    {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->author->addToPage($this);
        $this->date = new \DateTime();
    }

    public function addComment(string $comment): void
    {
        $this->comments[] = $comment;
    }

    /**
     * The `__clone` method is called when the `clone` keyword is used.
     */
    public function __clone()
    {
        $this->title = "Copy of " . $this->title;
        $this->author->addToPage($this);
        $this->comments = [];
        $this->date = new \DateTime();
    }

    public function getInfo(): string
    {
        return "Title: {$this->title}\n" .
            "Author: {$this->author->getName()}\n" .
            "Date: {$this->date->format('Y-m-d H:i:s')}\n" .
            "Comments: " . count($this->comments) . "\n";
    }
}

class Author
{
    private $name;
    private $pages = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addToPage(Page $page): void
    {
        $this->pages[] = $page;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

/**
 * Client code
 */
$author = new Author("John Smith");
$page = new Page("Design Patterns", "Prototype pattern is cool.", $author);
$page->addComment("Nice article!");

echo "Original Page:\n";
echo $page->getInfo();

sleep(1); // To show different timestamp

$clonedPage = clone $page;

echo "\nCloned Page (initialized from original but modified via __clone):\n";
echo $clonedPage->getInfo();

echo "\nNote how comments are empty in the clone and title is prefixed.\n";
