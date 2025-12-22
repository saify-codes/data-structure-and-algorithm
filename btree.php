<?php

class Node
{

    public function __construct(
        public $data,
        public $left = null,
        public $right = null
    ) {}
}

class BTree
{

    public $root;

    public function __construct()
    {
        $this->root = null;
    }

    public function insert($val)
    {

        $node  = new Node($val);

        if ($this->root == null) {
            $this->root = $node;
            return;
        }

        $current = $this->root;

        while (true) {

            if ($val <= $current->data) {

                if ($current->left == null) {
                    $current->left = $node;
                    break;
                }

                $current = $current->left;
            } else {

                if ($current->right == null) {
                    $current->right = $node;
                    break;
                }

                $current = $current->right;
            }
        }
    }

    public function find($val)
    {
        return $this->findRecursive($this->root, $val);
    }

    public function traverse($strategy='preorder')
    {
        match ($strategy) {
            'preorder'   => $this->preOrderTraversal($this->root),
            'inorder'    => $this->InOrderTraversal($this->root),
            'postorder'  => $this->PostOrderTraversal($this->root),
            'level'      => $this->LevelOrderTraversal($this->root),
            default      => throw new Exception('Invalid strategy')
        };
    }

    public function getDepthOfNode($val){
        return $this->calculateNodeDepth($this->root, $val);
    }

    public function getHeightOfTree(){
        return $this->calculateHeight($this->root);
    }

    public function getDepthOfTree(){
        return $this->calculateTreeDepth($this->root);        
    }

    public function getMinimumNode(){
        return $this->findMinimumNode($this->root);
    }

    public function isEqual($tree){
        return $this->compareTreeNodes($this->root, $tree->root);
    }

    public static function isValidBST($tree){



    }

    // Private helper methods for recursive operations

    private function validateBst($root, $min = PHP_INT_MIN, $max = PHP_INT_MAX) {
        if ($root == null) {
            return true;
        }

        // Current node must be within valid range
        if ($root->data <= $min || $root->data > $max) {
            return false;
        }

        // Left subtree: all nodes must be < current node
        // Right subtree: all nodes must be >= current node
        return $this->validateBst($root->left, $min, $root->data) &&
            $this->validateBst($root->right, $root->data, $max);
    }

    private function calculateHeight($root){
        
        if ($root == null) {
            return -1;
        }

        if ($root->left == null && $root->right == null) {
            return 0;
        }

        return max($this->calculateHeight($root->left), $this->calculateHeight($root->right)) + 1;
    }

    private function calculateNodeDepth($root, $val, $depth = 0){

        if ($root == null) {
            return -1;
        }

        if ($root->data == $val) {
            return $depth;
        }

        if ($root->data > $val) {
            return $this->calculateNodeDepth($root->left, $val, $depth + 1);
        }

        return $this->calculateNodeDepth($root->right, $val, $depth + 1);

    }

    private function calculateTreeDepth($root, $depth = 0){

        if ($root == null) {
            return -1;
        }

        if ($root->left == null && $root->right == null) {
            return $depth;
        }

        return max($this->calculateTreeDepth($root->left, $depth + 1), $this->calculateTreeDepth($root->right, $depth + 1));         

    }

    private function preOrderTraversal($root)
    {

        if ($root == null) {
            return;
        }

        print $root->data;
        $this->preOrderTraversal($root->left);
        $this->preOrderTraversal($root->right);
    }

    private function InOrderTraversal($root)
    {

        if ($root == null) {
            return;
        }

        $this->InOrderTraversal($root->left);
        print $root->data;
        $this->InOrderTraversal($root->right);
    }

    private function PostOrderTraversal($root)
    {

        if ($root == null) {
            return;
        }

        $this->PostOrderTraversal($root->left);
        $this->PostOrderTraversal($root->right);
        print $root->data;
    }

    private function LevelOrderTraversal($root){

        if ($this->root == null) {
            return;
        }

        $queue = [$this->root];

        while (count($queue) != 0) {
            
            $node = array_shift($queue);

            print $node->data;

            if ($node->left) {
                array_unshift($queue, $node->left);
            }

            if ($node->right) {
                array_unshift($queue, $node->right);
            }

        }



    }

    private function findRecursive($root, $val)
    {
        if ($root == null) {
            return;
        }

        if ($root->data == $val) {
            return true;
        }

        if ($root->data > $val) {
            return $this->findRecursive($root->left, $val);
        }

        return $this->findRecursive($root->right, $val);
    }

    private function findMinimumNode($root){

        if ($root == null) {
            return null;
        }

        if ($root->left == null) {
            return $root;
        }

        return $this->findMinimumNode($root->left);
        
    }

    private function compareTreeNodes($tree1, $tree2){
        
        if ($tree1 == null || $tree2 == null) {
            return $tree1 == $tree2;
        }

        return $tree1->data == $tree2->data &&
                $this->compareTreeNodes($tree1->left, $tree2->left) &&
                $this->compareTreeNodes($tree1->right, $tree2->right);
    }
}

$tree = new BTree;
$tree2 = new BTree;

foreach ([10,9,8,7,6,5,4,3,2,1] as $i) {
    $tree->insert($i);
    $tree2->insert($i);
}

print $tree->traverse();
