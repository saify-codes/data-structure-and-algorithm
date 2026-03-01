<?php

/*
|--------------------------------------------------------------------------
| 1. Memento (State Snapshot)
|--------------------------------------------------------------------------
*/

class EditorMemento
{
    public function __construct(private string $content) {}

    public function getContent(): string
    {
        return $this->content;
    }
}

/*
|--------------------------------------------------------------------------
| 2. Originator (Real Object)
|--------------------------------------------------------------------------
*/

class TextEditor
{
    private string $content = '';

    public function write(string $text): void
    {
        $this->content .= $text;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function save(): EditorMemento
    {
        return new EditorMemento($this->content);
    }

    public function restore(EditorMemento $memento): void
    {
        $this->content = $memento->getContent();
    }
}

/*
|--------------------------------------------------------------------------
| 3. Caretaker (History Manager)
|--------------------------------------------------------------------------
*/

class History
{
    private array $snapshots = [];

    public function push(EditorMemento $memento): void
    {
        $this->snapshots[] = $memento;
    }

    public function pop(): ?EditorMemento
    {
        return array_pop($this->snapshots);
    }
}

/*
|--------------------------------------------------------------------------
| 4. Usage
|--------------------------------------------------------------------------
*/

$editor = new TextEditor();
$history = new History();

$editor->write("Hello");
$history->push($editor->save());

$editor->write(" World");
$history->push($editor->save());

echo "Current: " . $editor->getContent() . "\n";

/* Undo */
$editor->restore($history->pop());

echo "After Undo: " . $editor->getContent() . "\n";