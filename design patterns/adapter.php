<?php

interface PaymentGateway
{
    public function processPayment($amount);
}

interface EPaymentGateway
{
    public function process($amount);
}



class CardPayment implements PaymentGateway
{
    
    public function processPayment($amount)
    {
        return "Paid {$amount} using Card\n";
    }
}

class EPaymentAdapter implements EPaymentGateway
{
    private $gateway;

    public function __construct(PaymentGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function process($amount)
    {
        return $this->gateway->processPayment($amount);
    }
}


$obj = new EPaymentAdapter(new CardPayment());
echo $obj->process(100);