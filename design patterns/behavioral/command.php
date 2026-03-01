<?php

/*
|--------------------------------------------------------------------------
| 1. Command Interface
|--------------------------------------------------------------------------
*/

interface _Command
{
    public function execute(): void;
}

/*
|--------------------------------------------------------------------------
| 2. Receiver
|--------------------------------------------------------------------------
*/

class Light
{
    public function turnOn(): void
    {
        echo "Light is ON\n";
    }

    public function turnOff(): void
    {
        echo "Light is OFF\n";
    }
}

/*
|--------------------------------------------------------------------------
| 3. Concrete Commands
|--------------------------------------------------------------------------
*/

class LightOnCommand implements _Command
{
    public function __construct(private Light $light) {}

    public function execute(): void
    {
        $this->light->turnOn();
    }
}

class LightOffCommand implements _Command
{
    public function __construct(private Light $light) {}

    public function execute(): void
    {
        $this->light->turnOff();
    }
}

/*
|--------------------------------------------------------------------------
| 4. Invoker
|--------------------------------------------------------------------------
*/

class RemoteControl
{
    private _Command $command;

    public function setCommand(_Command $command): void
    {
        $this->command = $command;
    }

    public function pressButton(): void
    {
        $this->command->execute();
    }
}

/*
|--------------------------------------------------------------------------
| 5. Usage
|--------------------------------------------------------------------------
*/

$light = new Light();
$remote = new RemoteControl();

/* Direct call without Command */
echo "Without Command Pattern:\n";
$light->turnOn();
$light->turnOff();

echo "\nWith Command Pattern:\n";

$remote->setCommand(new LightOnCommand($light));
$remote->pressButton();

$remote->setCommand(new LightOffCommand($light));
$remote->pressButton();


/*
|--------------------------------------------------------------------------
| 1. Command Interface
|--------------------------------------------------------------------------
*/

interface Command
{
    public function execute(): void;
    public function undo(): void;
}

/*
|--------------------------------------------------------------------------
| 2. Receiver (Real Logic)
|--------------------------------------------------------------------------
*/

class BankAccount
{
    private int $balance = 0;

    public function deposit(int $amount): void
    {
        $this->balance += $amount;
        echo "Deposited: $amount | Balance: {$this->balance}\n";
    }

    public function withdraw(int $amount): void
    {
        if ($amount > $this->balance) {
            throw new Exception("Insufficient balance");
        }

        $this->balance -= $amount;
        echo "Withdrawn: $amount | Balance: {$this->balance}\n";
    }

    public function getBalance(): int
    {
        return $this->balance;
    }
}

/*
|--------------------------------------------------------------------------
| 3. Concrete Commands
|--------------------------------------------------------------------------
*/

class DepositCommand implements Command
{
    public function __construct(
        private BankAccount $account,
        private int $amount
    ) {}

    public function execute(): void
    {
        $this->account->deposit($this->amount);
    }

    public function undo(): void
    {
        $this->account->withdraw($this->amount);
    }
}

class WithdrawCommand implements Command
{
    public function __construct(
        private BankAccount $account,
        private int $amount
    ) {}

    public function execute(): void
    {
        $this->account->withdraw($this->amount);
    }

    public function undo(): void
    {
        $this->account->deposit($this->amount);
    }
}

/*
|--------------------------------------------------------------------------
| 4. Macro Command (Multiple Commands Together)
|--------------------------------------------------------------------------
*/

class MacroCommand implements Command
{
    private array $commands = [];

    public function add(Command $command): void
    {
        $this->commands[] = $command;
    }

    public function execute(): void
    {
        foreach ($this->commands as $command) {
            $command->execute();
        }
    }

    public function undo(): void
    {
        foreach (array_reverse($this->commands) as $command) {
            $command->undo();
        }
    }
}

/*
|--------------------------------------------------------------------------
| 5. Command Manager (Queue + Logging + Retry + Undo)
|--------------------------------------------------------------------------
*/

class CommandManager
{
    private array $queue = [];
    private array $history = [];

    public function addToQueue(Command $command): void
    {
        $this->queue[] = $command;
        $this->log("Command added to queue");
    }

    public function run(): void
    {
        echo "\nExecuting Queue...\n";

        foreach ($this->queue as $command) {
            $this->executeWithRetry($command);
        }

        $this->queue = [];
    }

    private function executeWithRetry(Command $command, int $retry = 1): void
    {
        try {
            $command->execute();
            $this->history[] = $command;
            $this->log("Command executed");
        } catch (Exception $e) {

            $this->log("Error: " . $e->getMessage());

            if ($retry > 0) {
                $this->log("Retrying command...");
                $this->executeWithRetry($command, $retry - 1);
            } else {
                $this->log("Command failed permanently");
            }
        }
    }

    public function undoLast(): void
    {
        $command = array_pop($this->history);

        if ($command) {
            echo "\nUndoing last command...\n";
            $command->undo();
            $this->log("Command undone");
        }
    }

    private function log(string $message): void
    {
        file_put_contents(
            'command_log.txt',
            "[" . date('H:i:s') . "] " . $message . PHP_EOL,
            FILE_APPEND
        );
    }
}

/*
|--------------------------------------------------------------------------
| 6. FULL DEMO
|--------------------------------------------------------------------------
*/

$account = new BankAccount();
$manager = new CommandManager();

/* Queue simple commands */
$manager->addToQueue(new DepositCommand($account, 1000));
$manager->addToQueue(new WithdrawCommand($account, 200));

/* Create macro command */
$macro = new MacroCommand();
$macro->add(new DepositCommand($account, 500));
$macro->add(new WithdrawCommand($account, 100));

$manager->addToQueue($macro);

/* Add failing command */
$manager->addToQueue(new WithdrawCommand($account, 5000));

/* Execute later */
$manager->run();

/* Undo last successful command */
$manager->undoLast();

echo "\nFinal Balance: " . $account->getBalance() . "\n";