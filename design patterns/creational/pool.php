<?php

class Connection
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function query($sql)
    {
        return "Conn {$this->id} executing: {$sql}\n";
    }
}

class ConnectionPool
{
    private $available;
    private $inUse;
    private $capacity;

    public function __construct($capacity = 5)
    {
        $this->capacity     = $capacity;
        $this->available    = [];
        $this->inUse        = [];
    }

    public function acquire(){

        if(!empty($this->available)){
            $conn = array_pop($this->available);
        }else if (count($this->inUse) < $this->capacity) {
            $conn = new Connection(uniqid());
        }else{
            throw new Exception("Pool Exhausted");
        }

        $this->inUse[spl_object_id($conn)] = $conn;
        return $conn;

    }

    public function release(Connection $connection){

        $id = spl_object_id($connection);

        if (isset($this->inUse[$id])) {
            unset($this->inUse[$id]);
            $this->available[] = $connection;
        }

    }
}




$pool = new ConnectionPool();

$conn1 = $pool->acquire();
echo $conn1->query("SELECT 1");
echo $conn1->query("SELECT 1");
echo $conn1->query("SELECT 1");
echo $conn1->query("SELECT 1");
echo $conn1->query("SELECT 1");

$conn2 = $pool->acquire(); 
echo $conn2->query("SELECT 2");
echo $conn2->query("SELECT 2");
echo $conn2->query("SELECT 2");
echo $conn2->query("SELECT 2");
echo $conn2->query("SELECT 2");

$conn3 = $pool->acquire(); 
echo $conn3->query("SELECT 3");
echo $conn3->query("SELECT 3");
echo $conn3->query("SELECT 3");
echo $conn3->query("SELECT 3");
echo $conn3->query("SELECT 3");

$pool->acquire();
$pool->acquire();
$pool->acquire();
