<?php

interface Payment{

    function pay($amount);
    function getBalance();
    function topup();
}

interface MobilePayment{

    function sendMoney($amount);
    function checkBalance();
    function recharge();
}

class Mcb implements Payment{

    function pay($amount)
    {
        print "Paying $amount using MCB";
    }
    
    function getBalance()
    {
        print "Getting balance from MCB";
    }

    function topup()
    {
        print "Topping up MCB";
    }
}

class MobilePaymentAdapter implements MobilePayment{

    private $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    function sendMoney($amount)
    {
        $this->payment->pay($amount);
    }
    
    function checkBalance()
    {
        $this->payment->getBalance();
    }

    function recharge()
    {
        $this->payment->topup();
    }
   
}

$o = new MobilePaymentAdapter(new Mcb);


$o->sendMoney(444);