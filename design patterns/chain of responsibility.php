<?php

abstract class Approver
{
   protected $approver;

   public function setApprover(Approver $approver){
    $this->approver = $approver;
    return $approver;
   }

   public function handle(float $amount){

    if ($this->approver) {
       return $this->approver->handle($amount);
    }

    print "No approver available for amount $amount" . PHP_EOL;
   }
}

class Manager extends Approver
{
    function handle(float $amount)
    {
        if ($amount < 1000) {
            echo "Manager approved the request of $amount" . PHP_EOL;
        } else {
            parent::handle($amount);
        }
    }
}

class Director extends Approver
{
    function handle(float $amount)
    {
        if ($amount < 5000) {
            echo "Director approved the request of $amount" . PHP_EOL;
        } else {
            parent::handle($amount);
        }
    }
}

class CEO extends Approver
{
    function handle(float $amount)
    {
        if ($amount < 10000) {
            echo "CEO approved the request of $amount" . PHP_EOL;
        } else {
            echo "Request of $amount requires board approval." . PHP_EOL;
        }
    }
}

$manager  = new Manager();
$director = new Director();
$ceo      = new CEO();
$amount   = 9000;

$manager->setApprover($director)->setApprover($ceo);
$manager->handle($amount);