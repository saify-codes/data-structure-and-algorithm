<?php


class Stack{
 
    private $pointer;
    private $size;
    private $array;

    public function __construct($capacity = 5){
        $this->pointer = -1;
        $this->size = $capacity;
        $this->array = new SplFixedArray($capacity);
    }

    public function full(){
        return $this->pointer == $this->size - 1;
    }

    public function empty(){
        return $this->pointer == -1;
    }

    public function push($val){

        if($this->full()){
            throw new Exception('Overflow');
        }

        $this->array[++$this->pointer] = $val;
    }

    public function pop(){

        if($this->empty()){
            throw new Exception('Underflow');
        }

        return $this->array[$this->pointer--];
    }

    public function peek(){

        if($this->empty()){
            throw new Exception('Empty');
        }

        return $this->array[$this->pointer];
    }
    
}

$stack = new Stack();

$stack->push(1);
$stack->push(2);
$stack->push(3);
$stack->push(4);
$stack->push(5);

print $stack->pop();