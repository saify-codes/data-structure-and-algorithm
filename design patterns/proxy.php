<?php

/*
|--------------------------------------------------------------------------
| 1. Access Control Proxy
|--------------------------------------------------------------------------
*/

interface FileAccess {
    public function readFile(): void;
}

class RealFile implements FileAccess {
    public function readFile(): void {
        echo "Reading secret file...\n";
    }
}

class AccessControlProxy implements FileAccess {
    private RealFile $realFile;
    private string $userRole;

    public function __construct(string $userRole) {
        $this->userRole = $userRole;
        $this->realFile = new RealFile();
    }

    public function readFile(): void {
        if ($this->userRole !== "admin") {
            echo "Access Denied!\n";
            return;
        }

        $this->realFile->readFile();
    }
}

/*
|--------------------------------------------------------------------------
| 2. Lazy Loading Proxy
|--------------------------------------------------------------------------
*/

interface Image {
    public function display(): void;
}

class RealImage implements Image {
    private string $filename;

    public function __construct(string $filename) {
        $this->filename = $filename;
        echo "Loading image from disk: {$this->filename}\n";
    }

    public function display(): void {
        echo "Displaying image: {$this->filename}\n";
    }
}

class LazyImageProxy implements Image {
    private ?RealImage $realImage = null;
    private string $filename;

    public function __construct(string $filename) {
        $this->filename = $filename;
    }

    public function display(): void {
        if ($this->realImage === null) {
            $this->realImage = new RealImage($this->filename);
        }

        $this->realImage->display();
    }
}

/*
|--------------------------------------------------------------------------
| 3. Logging / Monitoring Proxy
|--------------------------------------------------------------------------
*/

interface Database {
    public function query(string $sql): void;
}

class RealDatabase implements Database {
    public function query(string $sql): void {
        echo "Executing query: {$sql}\n";
    }
}

class LoggingDatabaseProxy implements Database {
    private RealDatabase $realDatabase;

    public function __construct() {
        $this->realDatabase = new RealDatabase();
    }

    public function query(string $sql): void {
        echo "[LOG] User requested query: {$sql}\n";

        $start = microtime(true);

        $this->realDatabase->query($sql);

        $end = microtime(true);
        $timeTaken = $end - $start;

        echo "[LOG] Query finished in {$timeTaken} seconds\n";
    }
}

/*
|--------------------------------------------------------------------------
| Test
|--------------------------------------------------------------------------
*/

echo "===== Access Control Proxy =====\n";
$user = new AccessControlProxy("user");
$user->readFile();

$admin = new AccessControlProxy("admin");
$admin->readFile();

echo "\n===== Lazy Loading Proxy =====\n";
$image = new LazyImageProxy("photo.jpg");
echo "Proxy created. Image not loaded yet.\n";
$image->display();
$image->display();

echo "\n===== Logging / Monitoring Proxy =====\n";
$db = new LoggingDatabaseProxy();
$db->query("SELECT * FROM users");