<?php

require "./linked list.php";

class HashMap {

    private SplFixedArray $arr;
    private int $size = 0;

    public function __construct(int $capacity = 10) {
        $this->arr = new SplFixedArray($capacity);
    }

    public function put(string $key, $val): void {

        $index  = $this->hash($key);
        

        if ($this->arr[$index] === null) {
            $this->arr[$index] = new LinkedList();
        }

        foreach ($this->arr[$index] as &$item) {
            if (isset($item->data[$key])) {
                $item[$key] = $val;
                return;
            }
        }

        $this->arr[$index]->insertTail([$key => $val]);
        $this->size++;
    }

    public function get(string $key) {

        $index = $this->hash($key);
        $bucket = $this->arr[$index];

        if ($bucket === null) {
            throw new Exception("Invalid key");
        }

        foreach ($bucket as $item) {
            if (isset($item->data[$key])) {
                return $item->data[$key];
            }
        }

        throw new Exception("Invalid key");
    }


    private function hash(string $key): int {

        $hash = 0;

        for ($i = 0; $i < strlen($key); $i++) {
            $hash += ord($key[$i]);
        }

        return $hash % $this->arr->count();
    }
}


$map = new HashMap(10);

$map->put("name", "anas");
$map->put("age", 25);

echo $map->get("name"); // anas

// $map->delete("name");
