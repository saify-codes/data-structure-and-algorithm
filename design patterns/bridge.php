<?php


#Idenify the problem
class EmailBasicNotification
{
    public function send(string $message, string $recipient)
    {
        echo "Sending basic email to $recipient: $message";
    }
}

class SMSBasicNotification
{
    public function send(string $message, string $recipient)
    {
        echo "Sending basic SMS to $recipient: $message";
    }
}

class WhatsappBasicNotification
{
    public function send(string $message, string $recipient)
    {
        echo "Sending basic Whatsapp to $recipient: $message";
    }
}

class EmailAlertNotification
{
    public function send(string $message, string $recipient)
    {
        echo "Sending email alert to $recipient: $message";
    }
}

class SMSAlertNotification
{
    public function send(string $message, string $recipient)
    {
        echo "Sending SMS alert to $recipient: $message";
    }
}

class WhatsappAlertNotification
{
    public function send(string $message, string $recipient)
    {
        echo "Sending Whatsapp alert to $recipient: $message";
    }
}

class EmailUrgentNotification
{
    public function send(string $message, string $recipient)
    {
        echo "Sending urgent alert email to $recipient: $message";
    }
}

class SMSUrgentNotification
{
    public function send(string $message, string $recipient)
    {
        echo "Sending urgent alert SMS to $recipient: $message";
    }
}

class WhatsappUrgentNotification
{
    public function send(string $message, string $recipient)
    {
        echo "Sending urgent alert Whatsapp to $recipient: $message";
    }
}

#Solution


interface Message{
    public function send(string $message, string $recipient);
}

class Sms implements Message{
    public function send(string $message, string $recipient){
        echo "SMS: $message" . PHP_EOL;
    }
}

class Email implements Message{
    public function send(string $message, string $recipient){
        echo "Email: $message" . PHP_EOL;
    }
}

class Whatsapp implements Message{
    public function send(string $message, string $recipient){
        echo "Whatsapp: $message" . PHP_EOL;
    }
}

abstract class Notification{
    protected Message $message;

    public function __construct(Message $message)   
    {
        $this->message = $message;
    }

    abstract function notify(string $message, string $recipient);
}

class BasicNotification extends Notification{
 
    function notify(string $message, string $recipient){
        $message = "\033[32m" . $message . " ✓\033[0m";
        $this->message->send($message, $recipient);
    }
    
}

class AlertNotification extends Notification{
 
    function notify(string $message, string $recipient){
        $message = "\033[33m" . $message . " ⚠️\033[0m";
        $this->message->send($message, $recipient);
    }
    
}

class UrgentNotification extends Notification{
 
    function notify(string $message, string $recipient){
        $message = "\033[31m" . $message . " 🚨\033[0m";
        $this->message->send($message, $recipient);
    }
    
}

#mediums
$sms        = new Sms();
$email      = new Email();
$whatsapp   = new Whatsapp();

#notifications
$basicNotification  = new BasicNotification($sms);
$alertNotification  = new AlertNotification($email);
$urgentNotification = new UrgentNotification($whatsapp);

$basicNotification->notify("System is running...", "john@gmail.com");
$alertNotification->notify("System memory is almost full", "john@gmail.com");
$urgentNotification->notify("Critical! server is down", "john@gmail.com");