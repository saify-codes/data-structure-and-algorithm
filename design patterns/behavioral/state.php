<?php

interface OrderState
{
    public function pay(Order $order);
    public function refund(Order $order);
    public function dispatch(Order $order);
    public function cancel(Order $order);
    public function deliver(Order $order);
}

class InitialState implements OrderState
{
    public function pay(Order $order)
    {
        echo "Order paid successfully\n";
        $order->setState(new PaidState());
    }

    public function refund(Order $order)
    {
        throw new Exception("Order not paid yet, cannot refund.");
    }

    public function dispatch(Order $order)
    {
        throw new Exception("Order not paid yet, cannot dispatch.");
    }

    public function cancel(Order $order)
    {
        echo "Order cancelled successfully\n";
        $order->setState(new CancelledState());
    }

    public function deliver(Order $order)
    {
        throw new Exception("Order not paid yet, cannot deliver.");
    }
}

class PaidState implements OrderState
{
    public function pay(Order $order)
    {
        throw new Exception("Order already paid.");
    }

    public function refund(Order $order)
    {
        echo "Order refunded successfully\n";
        $order->setState(new InitialState());
    }

    public function dispatch(Order $order)
    {
        echo "Order dispatched successfully\n";
        $order->setState(new DispatchedState());
    }

    public function cancel(Order $order)
    {
        echo "Order cancelled successfully\n";
        $order->setState(new CancelledState());
    }

    public function deliver(Order $order)
    {
        throw new Exception("Order not dispatched yet, cannot deliver.");
    }
}

class DispatchedState implements OrderState
{
    public function pay(Order $order)
    {
        throw new Exception("Order already paid.");
    }

    public function refund(Order $order)
    {
        throw new Exception("Order already dispatched, cannot refund directly. Cancel first (if allowed).");
    }

    public function dispatch(Order $order)
    {
        throw new Exception("Order already dispatched.");
    }

    public function cancel(Order $order)
    {
        echo "Order cancelled from dispatched state\n";
        $order->setState(new CancelledState());
    }

    public function deliver(Order $order)
    {
        echo "Order delivered successfully\n";
        $order->setState(new DeliveredState());
    }
}

class DeliveredState implements OrderState
{
    public function pay(Order $order)
    {
        throw new Exception("Order already paid and delivered.");
    }

    public function refund(Order $order)
    {
        echo "Order returned and refunded successfully\n";
        $order->setState(new InitialState());
    }

    public function dispatch(Order $order)
    {
        throw new Exception("Order already delivered.");
    }

    public function cancel(Order $order)
    {
        throw new Exception("Order already delivered, cannot cancel.");
    }

    public function deliver(Order $order)
    {
        throw new Exception("Order already delivered.");
    }
}

class CancelledState implements OrderState
{
    public function pay(Order $order)
    {
        throw new Exception("Order is cancelled.");
    }

    public function refund(Order $order)
    {
        throw new Exception("Order is cancelled.");
    }

    public function dispatch(Order $order)
    {
        throw new Exception("Order is cancelled.");
    }

    public function cancel(Order $order)
    {
        throw new Exception("Order is already cancelled.");
    }

    public function deliver(Order $order)
    {
        throw new Exception("Order is cancelled.");
    }
}

class Order
{
    private $state;

    public function __construct()
    {
        $this->state = new InitialState();
    }

    public function setState(OrderState $state)
    {
        $this->state = $state;
    }

    public function pay()
    {
        $this->state->pay($this);
    }

    public function refund()
    {
        $this->state->refund($this);
    }

    public function dispatch()
    {
        $this->state->dispatch($this);
    }

    public function cancel()
    {
        $this->state->cancel($this);
    }

    public function deliver()
    {
        $this->state->deliver($this);
    }
}

// Test usage
try {
    $order = new Order();
    $order->dispatch();
    $order->pay();
    $order->deliver();
    //$order->cancel(); // Should throw exception
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}