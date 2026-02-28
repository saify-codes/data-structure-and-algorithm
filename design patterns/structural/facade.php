<?php

/**
 * =========================
 * Subsystem Classes
 * =========================
 */

class CPU
{
    public function freeze(): string
    {
        return "CPU freezing...\n";
    }

    public function execute(): string
    {
        return "CPU executing instructions...\n";
    }
}

class Memory
{
    public function load(): string
    {
        return "Memory loading data...\n";
    }
}

class HardDrive
{
    public function read(): string
    {
        return "Hard drive reading boot sector...\n";
    }
}

/**
 * =========================
 * Facade
 * =========================
 */

class ComputerFacade
{
    private CPU $cpu;
    private Memory $memory;
    private HardDrive $hardDrive;

    public function __construct()
    {
        $this->cpu = new CPU();
        $this->memory = new Memory();
        $this->hardDrive = new HardDrive();
    }

    public function startComputer(): void
    {
        echo $this->cpu->freeze();
        echo $this->memory->load();
        echo $this->hardDrive->read();
        echo $this->cpu->execute();
        echo "Computer started successfully.\n";
    }
}

/**
 * =========================
 * Client Code
 * =========================
 */

$computer = new ComputerFacade();
$computer->startComputer();