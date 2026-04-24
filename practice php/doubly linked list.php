<?php

class Node
{
    public mixed $data;
    public ?Node $prev;
    public ?Node $next;

    public function __construct(mixed $data)
    {
        $this->data = $data;
        $this->next = null;
        $this->prev = null;
    }
}

class LinkedList
{
    public  ?Node $head;
    public  ?Node $tail;
    private int   $length;

    public function __construct()
    {
        $this->head   = null;
        $this->tail   = null;
        $this->length = 0;
    }

    public function shift()
    {

        if ($this->head === null) {
            throw new Exception("List is empty");
        }

        $node = $this->head;

        if ($this->head === $this->tail) {
            $this->head = null;
            $this->tail = null;
        } else {
            $this->head       = $this->head->next;
            $this->head->prev = null;
        }

        $this->length--;

        return $node->data;
    }

    public function unshift(mixed $val)
    {
        $node = new Node($val);

        if ($this->head === null) {
            $this->head = $node;
            $this->tail = $node;
        } else {
            $node->next = $this->head;
            $this->head->prev = $node;
            $this->head = $node;
        }

        $this->length++;
    }

    public function push(mixed $val)
    {
        $node = new Node($val);

        if ($this->tail === null) {
            $this->head = $node;
            $this->tail = $node;
        } else {
            $this->tail->next = $node;
            $node->prev = $this->tail;
            $this->tail = $node;
        }

        $this->length++;
    }

    public function pop()
    {
        if ($this->tail === null) {
            throw new Exception("List is empty");
        }

        $node = $this->tail;

        if ($this->tail === $this->head) {
            $this->head = null;
            $this->tail = null;
        } else {
            $this->tail       = $this->tail->prev;
            $this->tail->next = null;
        }


        $this->length--;

        return $node->data;
    }

    public function add(int $index, mixed $val)
    {
        if ($index < 0 || $index > $this->length) {
            throw new Exception("Index out of bounds");
        }

        if ($index === 0) {
            $this->unshift($val);
            return;
        }

        if ($index === $this->length) {
            $this->push($val);
            return;
        }

        $node = new Node($val);
        $curr = $this->getNode($index);

        $node->next = $curr;
        $node->prev = $curr->prev;
        $curr->prev->next = $node;
        $curr->prev = $node;

        $this->length++;
    }

    public function remove(int $index)
    {
        if ($index < 0 || $index >= $this->length) {
            throw new Exception("Index out of bounds");
        }

        if ($index === 0) {
            $this->shift();
            return;
        }

        if ($index === $this->length - 1) {
            $this->pop();
            return;
        }

        $curr = $this->getNode($index);

        $curr->prev->next = $curr->next;
        $curr->next->prev = $curr->prev;

        $this->length--;
    }

    public function __toString()
    {
        $str  = '';
        $curr = $this->head;
        while ($curr !== null) {
            $str .= $curr->data . ' -> ';
            $curr = $curr->next;
        }

        return $str  . 'NULL';
    }

    private function getNode($index)
    {

        $curr = $this->head;

        for ($i = 0; $i < $index; $i++) {

            if ($curr === null) {
                return null;
            }

            $curr = $curr->next;
        }

        return $curr;
    }
}


$list = new LinkedList();

$list->push(10);
$list->push(20);
$list->push(30);
$list->push(40);
$list->add(2, 10000);

print $list;
print "\n";
print "HEAD:" . ($list->head?->data);
print "\n";
print "TAIL:" . ($list->tail?->data);
