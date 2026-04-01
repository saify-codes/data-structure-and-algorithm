<?php

class Node{
    public $data;
    public $next;

    public function __construct($data){
        $this->data = $data;
        $this->next = null;
    }
}

class LList {

    private $head;
    private $tail;
    private $size;

    public function __construct()
    {
        $this->head = null;
        $this->tail = null;
        $this->size = 0;
    }

    public function insertAtHead($val){

        $node = new Node($val);

        if ($this->empty()) {
            $this->head = $node;
            $this->tail = $node;
        }else{
            $node->next = $this->head;
            $this->head = $node;
        }

        $this->size++;

    }

    public function insertAtTail($val){

        $node = new Node($val);

        if ($this->empty()) {
            $this->head = $node;
            $this->tail = $node;
        }else{
            $this->tail->next = $node;
            $this->tail = $node;
        }

        $this->size++;

    }

    public function insertAtIndex($index, $val){
        
        if ($index == 0) {
            $this->insertAtHead($val);
            return;
        }

        $node = new Node($val);
        $curr = $this->head;

        for ($i=0; $i < $index - 1; $i++) {
            
            $curr = $curr->next;
            
            if($curr == null){
                throw new Exception("List is empty");
            }
        }

        $node->next = $curr->next;
        $curr->next = $node;
        $this->size++;
    }

    public function removeAtHead(){

        if ($this->empty()) {
            return;
        }

        if($this->head == $this->tail){
            $this->head = null;
            $this->tail = null;
        }else{
            $this->head = $this->head->next;
        }

        $this->size--;

    }

    public function removeAtTail(){

        if ($this->empty()) {
            return;
        }

        if($this->head == $this->tail){
            $this->head = null;
            $this->tail = null;
        }else{

            $curr = $this->head;
            while($curr->next != $this->tail){
                $curr = $curr->next;
            }

            $this->tail = $curr;
        }

        $this->size--;

    }

    public function removeAtIndex($index){
        
        if ($index == 0) {
            $this->removeAtHead();
            return;
        }

        $curr = $this->head;

        for ($i = 0; $i < $index - 1; $i++) {
            $curr = $curr->next;
            
            if ($curr == null) {
                throw new Exception("Invalid index $index");
            }
        }

        $curr->next = $curr->next->next;
        
        // Update tail if removing the last node
        if ($curr->next == null) {
            $this->tail = $curr;
        }

        $this->size--;
    }

    public function reverse(){

        $prev = null;
        $curr = $this->head;
        $next = null;

        
        while ($curr) {
            
            $next = $curr->next;
            $curr->next = $prev;
            $prev = $curr;
            $curr = $next;
        }
        
        $this->tail = $this->head;
        $this->head = $prev;

    }

    public function reverseRecursive(){

        $this->tail = $this->head;
        $this->head = $this->reverseHelper($this->head);

    }

    public function empty(){
        return $this->head == null && $this->tail == null;
    }

    public function getSize(){
        return $this->size;
    }

    private function reverseHelper($head){

        if($head == null || $head->next == null){
            return $head;
        }

        $newHead = $this->reverseHelper($head->next);

        $head->next->next = $head;
        $head->next       = null;

        return $newHead;
    }

}