<?php

/*
|--------------------------------------------------------------------------
| 1. Observer Interface
|--------------------------------------------------------------------------
*/

interface Observer
{
    public function update(string $message): void;
}

/*
|--------------------------------------------------------------------------
| 2. Subject Interface
|--------------------------------------------------------------------------
*/

interface Subject
{
    public function attach(Observer $observer): void;
    public function detach(Observer $observer): void;
    public function notify(): void;
}

/*
|--------------------------------------------------------------------------
| 3. Concrete Subject
|--------------------------------------------------------------------------
*/

class YouTubeChannel implements Subject
{
    private array $observers = [];
    private string $videoTitle;

    public function attach(Observer $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer): void
    {
        $this->observers = array_filter(
            $this->observers,
            fn($obs) => $obs !== $observer
        );
    }

    public function uploadVideo(string $title): void
    {
        $this->videoTitle = $title;
        echo "New Video Uploaded: $title\n";
        $this->notify();
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this->videoTitle);
        }
    }
}

/*
|--------------------------------------------------------------------------
| 4. Concrete Observers
|--------------------------------------------------------------------------
*/

class Subscriber implements Observer
{
    public function __construct(private string $name) {}

    public function update(string $message): void
    {
        echo "{$this->name} received notification: New video - $message\n";
    }
}

/*
|--------------------------------------------------------------------------
| 5. Usage
|--------------------------------------------------------------------------
*/

$channel = new YouTubeChannel();

$sub1 = new Subscriber("Ali");
$sub2 = new Subscriber("Ahmed");

$channel->attach($sub1);
$channel->attach($sub2);

$channel->uploadVideo("Observer Pattern in PHP");