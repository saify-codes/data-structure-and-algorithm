<?php

class Connection{
    public function __construct(public string $uid) {}
    public function exec($sql){
        print $this->uid . " Exceuting query: [$sql]\n";
    }
}

class ConnectionPool{

    private $available;
    private $inUse;
    private $capacity;
    public function __construct($capacity = 3) {

        $this->available = [];
        $this->inUse = [];
        $this->capacity = $capacity;

    }

    public function acquire(){
        
        if (!empty($this->available)) {
            $conn = array_pop($this->available);
        }elseif (count($this->inUse) < $this->capacity){
            $conn = new Connection(uniqid());
        }else{
            throw new Exception("Pool exhausted");
        }

        $id = spl_object_id($conn);
        $this->inUse[$id] = $conn;
        return $conn;
    }
    
    public function release(Connection $conn){
        $id = spl_object_id($conn);

        if (isset($this->inUse[$id])) {
            unset($this->inUse[$id]);
            $this->available[] = $conn;
        }

    }
}

$pool = new ConnectionPool();

$c1 = $pool->acquire();
$c2 = $pool->acquire();
$c3 = $pool->acquire();

$c1->exec("SELECT 1");
$c2->exec("SELECT 1");
$c3->exec("SELECT 2");

$pool->release($c3);
$c4 = $pool->acquire();

$c4->exec("SELECT 3");