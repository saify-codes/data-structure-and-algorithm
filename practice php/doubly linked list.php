<?php

ini_set('xdebug.max_nesting_level', -1);

class Node
{
    public  $data;
    public ?Node $prev;
    public ?Node $next;

    public function __construct(
        $data,
        ?Node $prev = null,
        ?Node $next = null
    ) {
        $this->data = $data;
        $this->prev = $prev;
        $this->next = $next;
    }
}


class DoublyLinkedList implements Countable, IteratorAggregate
{
    private ?Node $head = null;
    private ?Node $tail = null;
    private int $size = 0;


    public function addFirst($val): void
    {
        $this->linkFirst($val);
    }


    public function addLast($val): void
    {
        $this->linkLast($val);
    }


    public function add(int $index,  $val): void
    {
        // Allow adding at the end:
        // add(count(), $value)
        if ($index < 0 || $index > $this->size) {
            throw new OutOfBoundsException("Index error");
        }

        if ($index === 0) {
            $this->linkFirst($val);
            return;
        }

        if ($index === $this->size) {
            $this->linkLast($val);
            return;
        }

        $this->linkBefore($val, $this->nodeAt($index));
    }


    public function removeFirst(): void
    {
        if ($this->isEmpty()) {
            throw new UnderflowException("List is empty");
        }

        $this->unlinkFirst();
    }


    public function removeLast(): void
    {
        if ($this->isEmpty()) {
            throw new UnderflowException("List is empty");
        }

        $this->unlinkLast();
    }


    public function remove(int $index): void
    {
        $this->unlink($this->nodeAt($index));
    }


    public function isEmpty(): bool
    {
        return $this->size === 0;
    }


    /**
     * Reverse the list iteratively.
     *
     * Time: O(n)
     * Space: O(1)
     */
    public function reverse(): void
    {

        $curr = $this->head;

        while ($curr != null) {
            $next = $curr->next;
            $curr->next = $curr->prev;
            $curr->prev = $next;
            $curr = $next;
        }

        $oldHead = $this->head;
        $this->head = $this->tail;
        $this->tail = $oldHead;
    }


    /**
     * Reverse the list recursively.
     *
     * Time: O(n)
     * Space: O(n) due to call stack
     */
    public function reverseRecursive(): void
    {
        $this->reverseRecursiveNode($this->head);

        // Swap head and tail
        $oldHead = $this->head;
        $this->head = $this->tail;
        $this->tail = $oldHead;
    }


    private function reverseRecursiveNode(?Node $node): void
    {
        if ($node === null) {
            return;
        }

        $next = $node->next;

        $node->next = $node->prev;
        $node->prev = $next; 

        $this->reverseRecursiveNode($next);
    }


    public function count(): int
    {
        return $this->size;
    }


    public function getIterator(): Traversable
    {
        $current = $this->head;

        while ($current !== null) {
            yield $current;
            $current = $current->next;
        }
    }


    private function linkFirst($val): void
    {
        $head = $this->head;

        $node = new Node(
            $val,
            null,
            $head
        );

        $this->head = $node;

        if ($head === null) {
            $this->tail = $node;
        } else {
            $head->prev = $node;
        }

        $this->size++;
    }


    private function linkLast($val): void
    {
        $tail = $this->tail;

        $node = new Node(
            $val,
            $tail,
            null
        );

        $this->tail = $node;

        if ($tail === null) {
            $this->head = $node;
        } else {
            $tail->next = $node;
        }

        $this->size++;
    }


    private function linkBefore($val, Node $node): void
    {
        $prev = $node->prev;

        $newNode = new Node(
            $val,
            $prev,
            $node
        );

        $node->prev = $newNode;

        if ($prev === null) {
            $this->head = $newNode;
        } else {
            $prev->next = $newNode;
        }

        $this->size++;
    }


    private function unlinkFirst(): void
    {
        $node = $this->head;
        $next = $node->next;

        $this->head = $next;

        if ($next === null) {
            $this->tail = null;
        } else {
            $next->prev = null;
        }

        // Fully detach removed node
        $node->next = null;

        $this->size--;
    }


    private function unlinkLast(): void
    {
        $node = $this->tail;
        $prev = $node->prev;

        $this->tail = $prev;

        if ($prev === null) {
            $this->head = null;
        } else {
            $prev->next = null;
        }

        // Fully detach removed node
        $node->prev = null;

        $this->size--;
    }


    private function unlink(Node $node): void
    {
        $prev = $node->prev;
        $next = $node->next;

        if ($prev === null) {
            $this->head = $next;
        } else {
            $prev->next = $next;
        }

        if ($next === null) {
            $this->tail = $prev;
        } else {
            $next->prev = $prev;
        }

        // Fully detach node
        $node->prev = null;
        $node->next = null;

        $this->size--;
    }


    private function nodeAt(int $index): Node
    {
        if ($index < 0 || $index >= $this->size) {
            throw new OutOfBoundsException("Index error");
        }

        // Search from the closest side
        if ($index < intdiv($this->size, 2)) {

            $node = $this->head;

            for ($i = 0; $i < $index; $i++) {
                $node = $node->next;
            }
        } else {

            $node = $this->tail;

            for ($i = $this->size - 1; $i > $index; $i--) {
                $node = $node->prev;
            }
        }

        return $node;
    }
}


$list = new DoublyLinkedList();

for ($i = 0; $i < 10; $i++) {
    $list->addLast($i);
}


$list->reverseRecursive();

foreach ($list as $key => $value) {
    print_r($value->data);
}