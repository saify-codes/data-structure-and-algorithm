<?php

class Queue{

    private $array;
    private $front;
    private $rear;
    public function __construct($capacity = 5)
    {
        $this->array = new SplFixedArray($capacity);
        $this->front = -1;
        $this->rear  = -1;
    }
    function isEmpty() {
        return $this->front == -1 && $this->rear == -1;
    }
    function isFull() {
        return ($this->rear + 1) % sizeof($this->array) === $this->front;
    }
    public function peek() {
        
        if ($this->isEmpty()) {
            return null;
        }

        return $this->array[$this->front];

    }
    public function enqueue($val) {
        
        if ($this->isFull()) {
            throw new Exception("Overflow");
        }

        if ($this->front == -1) {
            $this->front++;
        }

        $this->rear = ($this->rear + 1) % sizeof($this->array);
        $this->array[$this->rear] = $val;

    }
    public function dequeue() {
        
        if ($this->isEmpty()) {
            throw new Exception("Underflow");
        }

        $val = $this->array[$this->front];

        if ($this->front == $this->rear) {
            $this->front = -1;
            $this->rear  = -1;
        }else{
            $this->front = ($this->front + 1) % sizeof($this->array);
        }

        return $val;
    }
}

