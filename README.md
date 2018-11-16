zi-agent Library
================

Installation
------------

```sh
composer require zingle/zi-agent
```

Usage
-----

```php
use Zingle\Infrastructure\Agent;
use Zingle\Infrastructure\Connection;

$agent = new Agent("foo-user", "-----BEGIN RSA PRIVATE KEY-----\nmTJJCjZ...")
$connection = new Connection("example.com", $agent);
$result = $connection->execute("my-command");

if ($result->getExit() !== 0) {
    echo $result->getOutput();
    echo "failed\n";
}

// if running multiple commands, explicitly open and close the connection
$connection->open();
// ... $result = $connection->execute("...");
// ... $result = $connection->execute("...");
$connection->close();
```
