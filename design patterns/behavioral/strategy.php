<?php

/*
|--------------------------------------------------------------------------
| 🔥 Strategy Design Pattern (Simple Intro)
|--------------------------------------------------------------------------
|
| Strategy pattern ka matlab:
| ek hi kaam ke multiple tareeqe ho sakte hain,
| aur hum runtime pe decide karte hain ke kaunsa tareeqa use karna hai.
|
| Is example me:
| hume order ka json banana hai (same kaam)
| lekin platform ke hisaab se tareeqa change hota hai:
|
| POS     → already correct format
| WEB     → convert karna hai
| MOBILE  → convert karna hai
| Normally 3 cheezein hoti hain:
|
| 1. Strategy Interface
| Ye batata hai har strategy me kaunsa method hoga.
|
| 2. Concrete Strategies
| Asli implementations, jaise PayPalStrategy, CardStrategy.
|
| 3. Context
| Wo class jo strategy ko use karti hai.
|
*/


/*
|--------------------------------------------------------------------------
| 🧩 PART 1: Strategy (Interface / Rule Book)
|--------------------------------------------------------------------------
|
| Ye rule define karta hai ke har strategy me ye method hona chahiye.
| Ye khud kaam nahi karta, sirf contract deta hai.
|
*/

interface EditOrderStrategy
{
    public function getJsonDetails(array $order): array;
}


/*
|--------------------------------------------------------------------------
| 🧩 PART 2: Concrete Strategies (Asli kaam yahan hota hai)
|--------------------------------------------------------------------------
|
| Har class ek alag tareeqa implement karti hai.
| Same method hai (getJsonDetails), lekin behavior different hai.
|
*/


// ✅ POS Strategy (no change needed)
class PosStrategy implements EditOrderStrategy
{
    public function getJsonDetails(array $order): array
    {
        return $order['json_details'];
    }
}


// ✅ WEB Strategy (convert web → POS format)
class WebStrategy implements EditOrderStrategy
{
    public function getJsonDetails(array $order): array
    {
        return [
            'order_id' => $order['json_details']['id'],
            'total' => $order['json_details']['grand_total'],
        ];
    }
}


// ✅ MOBILE Strategy (convert mobile → POS format)
class MobileStrategy implements EditOrderStrategy
{
    public function getJsonDetails(array $order): array
    {
        return [
            'order_id' => $order['json_details']['order_no'],
            'total' => $order['json_details']['total_amount'],
        ];
    }
}


/*
|--------------------------------------------------------------------------
| 🧩 PART 3: Context (Manager)
|--------------------------------------------------------------------------
|
| Ye class strategy ko use karti hai.
| Isko farq nahi padta kaunsi strategy hai,
| bas jo di jaye usko run karta hai.
|
*/

class Context
{
    private EditOrderStrategy $strategy;

    public function __construct(EditOrderStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(EditOrderStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function run(array $order): array
    {
        return $this->strategy->getJsonDetails($order);
    }
}


/*
|--------------------------------------------------------------------------
| 🚀 FLOW: $order → strategy choose → context run → result
|--------------------------------------------------------------------------
*/


// 🔹 Sample order (pos)
$posOrder = [
    'platform' => 'pos',
    'json_details' => [
        'order_id' => 10,
        'total' => 1500
    ]
];
// 🔹 Sample order (web)
$webOrder = [
    'platform' => 'web',
    'json_details' => [
        'id' => 10,
        'grand_total' => 1500
    ]
];
// 🔹 Sample order (mobile)
$mobileOrder = [
    'platform' => 'mobile',
    'json_details' => [
        'order_no' => 10,
        'total_amount' => 1500
    ]
];
$order = $mobileOrder; // Change this to test different platforms
$context = new Context(new PosStrategy()); // Default strategy (POS)

// Strategy choose (platform ke hisaab se)
if ($order['platform'] === 'web') {
    $context->setStrategy(new WebStrategy());
}
elseif ($order['platform'] === 'mobile') {
    $context->setStrategy(new MobileStrategy());
}

$result = $context->run($order);

print_r($result);