<?php

class Node
{

    public function __construct(
        public $data,
        public $height = 0,
        public $left   = null,
        public $right  = null,
    ) {}
}

class AVLTree
{

    public $root;

    public function __construct()
    {
        $this->root = null;
    }

    public function insert($val)
    {
        $this->root = $this->insertRecursive($this->root, $val);

    }

    private function insertRecursive($root, $val){

        if ($root == null) {
            return new Node($val);
        }

        if ($root->data < $val) {
            $root->right = $this->insertRecursive($root->right, $val);
        }else{
            $root->left  = $this->insertRecursive($root->left, $val);
        }

        $root->height = max($this->getHeight($root->left), $this->getHeight($root->right)) + 1;

        if (!$this->isBalanced($root)) {
            
            if ($this->isLeftHeavy($root)) {
               if ($this->getBalanceFactor($root->left) < 0 ) {
               }
            }
            else if ($this->isRightHeavy($root)) {
                if ($this->getBalanceFactor($root->right) > 0 ) {
                }
                print "RIGHT HEAVY";
            }
            
        }

        return $root;
        
    }

    private function getBalanceFactor($node){

        if ($node == null) {
            return 0;
        }

        return $this->getHeight($node->left) - $this->getHeight($node->right);

    }

    private function isBalanced($node){
        if ($node == null) {
            return true;
        }

        $balanceFactor = $this->getBalanceFactor($node);

        return $balanceFactor >= -1 && $balanceFactor <= 1;
    }

    private function getHeight($node){

        if ($node == null) {
            return -1;
        }

        return $node->height;
    }

    private function isLeftHeavy($node){
        if($node == null){
            return false;
        }

        $balanceFactor = $this->getBalanceFactor($node);

        return $balanceFactor > 1;
    }

    private function isRightHeavy($node){
        if($node == null){
            return false;
        }

        $balanceFactor = $this->getBalanceFactor($node);

        return $balanceFactor < -1;
    }

}

$avlTree = new AVLTree;

$avlTree->insert(10);
$avlTree->insert(11);
$avlTree->insert(12);
$a = new SplPriorityQueue();

$a->insert(1, 0);
