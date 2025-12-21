<?php

class Node{
    public function __construct(public $data, public $next = null) {}
}

class LinkedList{

    private $size;
    private $head;
    public $tail;

    public function __construct() {
        $this->size = 0;
        $this->head = null;
        $this->tail = null;
    }

    public function isEmpty(){
        return $this->head === null && $this->tail === null;
    }

    public function insertHead($val){

        $node = new Node($val);

        if ($this->isEmpty()) {
            $this->head = $node;
            $this->tail = $node;
        }else{
            $node->next = $this->head;
            $this->head = $node;
        }

        $this->size++;
    }

    public function insertTail($val){

        $node = new Node($val);

        if ($this->isEmpty()) {
            $this->head = $node;
            $this->tail = $node;
        }else{
            
            $this->tail->next = $node;
            $this->tail = $node;
        }

        $this->size++;
    }

    public function insertMiddle($index, $val){

        if ($index < 0 || $index > $this->size) {
            throw new Exception("Index out of bound");
        }

        if ($index === 0) {
            $this->insertHead($val);
            return;
        }

        if ($index === $this->size) {
            $this->insertTail($val);
            return;
        }
        
        $node     = new Node($val);
        $previous = null;
        $current  = $this->head;

        while ($index > 0) {
            $previous = $current;
            $current  = $current->next;
            $index--;
        }

        $previous->next = $node;
        $node->next     = $current;
        $this->size++;
    }

    public function removeHead(){

        if ($this->isEmpty()) {
            return;
        }

        if ($this->head == $this->tail) {
            $this->head = null;   
            $this->tail = null;   
        }else{
            $this->head = $this->head->next;
        }

        $this->size--;

    }

    public function removeTail(){

        if ($this->isEmpty()) {
            return;
        }

        if ($this->head == $this->tail) {
            $this->head = null;   
            $this->tail = null;   
        }else{
            
            $current = $this->head;
            while ($current->next != $this->tail){
                $current = $current->next;
            }

            $current->next = null;
            $this->tail = $current;

        }

        $this->size--;

    }

    public function removeMiddle($index){

        if ($index < 0 || $index > $this->size - 1) {
            throw new Exception("Index out of bound");
        }

        if ($index === 0) {
            $this->removeHead();
            return;
        }

        if ($index === $this->size - 1) {
            $this->removeTail();
            return;
        }
        
        $previous = null;
        $current  = $this->head;

        while ($index > 0) {
            $previous = $current;
            $current  = $current->next;
            $index--;
        }

        $previous->next = $current->next;
        $this->size--;
    }

    public function reverse(){

        $next     = null;
        $previous = null;
        $current  = $this->head;

        while ($current) {
            
            $next          = $current->next;
            $current->next = $previous;
            $previous      = $current;
            $current       = $next;
        }

        $this->tail = $this->head;
        $this->head = $previous;
    }

    public function reverseRecursiv(){

        $this->tail = $this->head;
        $this->head = $this->reverseRecursiveHelper($this->head);
    }

    public function traverse(){

        $current = $this->head;

        while ($current) {
            print $current->data . " ";
            $current = $current->next;
        }
    }

    public function getIterator(): Traversable {
        $current = $this->head;

        while ($current !== null) {
            yield $current;
            $current = $current->next;
        }
    }

    private function reverseRecursiveHelper($head){

        if ($head == null || $head->next == null){
            return $head;
        }
        
        $newHead = $this->reverseRecursiveHelper($head->next);
        $head->next->next = $head;
        $head->next       = null;

        return $newHead;

    }
    
}