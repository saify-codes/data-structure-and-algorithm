<?php


class Queue{
 
    private $front;
    private $rear;
    private $size;
    private $array;

    public function __construct($capacity = 5){
        $this->front = -1;
        $this->rear = -1;
        $this->size = $capacity;
        $this->array = new SplFixedArray($capacity);
    }

    public function full(){
        return ($this->rear + 1) % $this->size == $this->front;
    }

    public function empty(){
        return $this->front == -1
                && $this->rear == -1;
    }

    public function enqueue($val){

        if($this->full()){
            throw new Exception('Overflow');
        }

        if ($this->front == -1) {
            $this->front++;
        }

        $this->rear = ($this->rear + 1) % $this->size;
        $this->array[$this->rear] = $val;
    }

    public function dequeue(){

        if($this->empty()){
            throw new Exception('Underflow');
        }

        $val = $this->array[$this->front];

        if ($this->front == $this->rear) {
            $this->front = -1;
            $this->rear  = -1;
        }else{
            $this->front = ($this->front + 1) % $this->size;
        }

        return $val;
    }

    public function peek(){

        if($this->empty()){
            throw new Exception('Empty');
        }

        return $this->array[$this->front];
    }
    
}


$queue = new Queue();