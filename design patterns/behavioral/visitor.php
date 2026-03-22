<?php

// ==========================
// Visitor Interface
// ==========================
interface Visitor
{
    public function visitText(Text $text);
    public function visitImage(Image $image);
}

// ==========================
// Concrete Visitor
// ==========================
class PrintVisitor implements Visitor
{

    public function visitText(Text $text)
    {
        echo "Printing TEXT: " . $text->content . PHP_EOL;
    }

    public function visitImage(Image $image)
    {
        echo "Printing IMAGE: " . $image->file . PHP_EOL;
    }
}

// ==========================
// Another Visitor
// ==========================
class ExportVisitor implements Visitor
{

    public function visitText(Text $text)
    {
        echo "Exporting TEXT: " . strtoupper($text->content) . PHP_EOL;
    }

    public function visitImage(Image $image)
    {
        echo "Exporting IMAGE: " . $image->file . " [compressed]" . PHP_EOL;
    }
}

// ==========================
// Element Interface
// ==========================
interface Element
{
    public function accept(Visitor $visitor);
}

// ==========================
// Concrete Elements
// ==========================
class Text implements Element
{
    public $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function accept(Visitor $visitor)
    {
        $visitor->visitText($this);
    }
}

class Image implements Element
{
    public $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function accept(Visitor $visitor)
    {
        $visitor->visitImage($this);
    }
}

// ==========================
// Usage
// ==========================

// Elements
$text = new Text("Hello bheedu");
$image = new Image("photo.png");

// Visitors
$printVisitor = new PrintVisitor();
$exportVisitor = new ExportVisitor();

// Apply Print Visitor
echo "---- PRINT ----" . PHP_EOL;
$text->accept($printVisitor);
$image->accept($printVisitor);

// Apply Export Visitor
echo PHP_EOL . "---- EXPORT ----" . PHP_EOL;
$text->accept($exportVisitor);
$image->accept($exportVisitor);