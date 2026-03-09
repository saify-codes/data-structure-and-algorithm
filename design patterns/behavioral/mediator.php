<?php

interface ChatMediator
{
    public function send($message, User $from, User $to);
    public function broadcast($message, User $user);
    public function addUser(User $user);
}

class User{
    public $name;
    private $mediator;

    public function __construct($name, ChatMediator $mediator){
        $this->name = $name;
        $this->mediator = $mediator;
    }

    public function broadcast($message){
        $this->mediator->broadcast($message, $this);
    }

    public function send($message, User $user){
        $this->mediator->send($message, $this, $user);
    }

    public function receive($message, User $user){
        echo "{$this->name} received {$message} from {$user->name}\n";
    }
}

class Chatroom implements ChatMediator
{
    private $users = [];

    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    public function broadcast($message, User $sender)
    {
        foreach ($this->users as $user) {
            if($user != $sender){
                $user->receive($message, $sender);
            }
        }
    }

    public function send($message, User $from, User $to){
        $user = array_find($this->users, fn($u) => $u == $to);

        if($user){
            $user->receive($message, $from);
        }
    }
}

$chatroom   = new Chatroom();
$ali        = new User("Ali", $chatroom);
$daniyal    = new User("Daniyal", $chatroom);
$saify      = new User("Saify", $chatroom);
$oman       = new User("Oman", $chatroom);

$chatroom->addUser($ali);
$chatroom->addUser($daniyal);
$chatroom->addUser($saify);
$chatroom->addUser($oman);

$ali->send("Hello", $oman);