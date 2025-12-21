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

    private $root;

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
            default      => throw new Exception('Invalid strategy')
        };
    }

    public function depth($val){
        return $this->_depth($this->root, $val);
    }

    public function depthOfTree(){
        return $this->_depthOfTree($this->root);        
    }

    // recursive methods

    private function _depth($root, $val, $depth = 0){

        if ($root == null) {
            return -1;
        }

        if ($root->data == $val) {
            return $depth;
        }

        if ($root->data > $val) {
            return $this->_depth($root->left, $val, $depth + 1);
        }

        return $this->_depth($root->right, $val, $depth + 1);

    }

    private function _depthOfTree($root, $depth = 0){

        if ($root == null) {
            return -1;
        }

        if ($root->left == null && $root->right == null) {
            return $depth;
        }

        return max($this->_depthOfTree($root->left, $depth + 1), $this->_depthOfTree($root->right, $depth + 1));         

    }

    private function preOrderTraversal($root)
    {

        if ($root == null) {
            return;
        }

        print $root->data . "\n";
        $this->preOrderTraversal($root->left);
        $this->preOrderTraversal($root->right);
    }

    private function InOrderTraversal($root)
    {

        if ($root == null) {
            return;
        }

        $this->InOrderTraversal($root->left);
        print $root->data . "\n";
        $this->InOrderTraversal($root->right);
    }

    private function PostOrderTraversal($root)
    {

        if ($root == null) {
            return;
        }

        $this->PostOrderTraversal($root->left);
        $this->PostOrderTraversal($root->right);
        print $root->data . "\n";
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
}

$tree = new BTree;

foreach ([7,3,8,1,4,8,10] as $i) {
    $tree->insert($i);
}

print $tree->depth(743);
