<?php


class Stack{

    private $array;
    private $pointer;
    public function __construct($capacity = 5)
    {
        $this->array = new SplFixedArray($capacity);
        $this->pointer = -1;
    }
    function isEmpty() {
        return $this->pointer == -1;
    }
    function isFull() {
        return $this->pointer == sizeof($this->array) - 1;
    }
    public function peek() {
        
        if ($this->isEmpty()) {
            return null;
        }

        return $this->array[$this->pointer];

    }
    public function push($val) {
        
        if ($this->isFull()) {
            throw new Exception("Overflow");
        }

        $this->array[++$this->pointer] = $val;

    }
    public function pop() {
        
        if ($this->isEmpty()) {
            throw new Exception("Underflow");
        }

        return $this->array[$this->pointer--];
    }
}

$stack = new Stack();

$stack->push(1);
$stack->push(2);
$stack->push(3);
$stack->push(4);
$stack->push(5);