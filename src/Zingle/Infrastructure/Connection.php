<?php

namespace Zingle\Infrastructure;
use phpseclib\Net\SSH2;
use LogicException;
use RuntimeException;

/**
 * Connection to host in Zingle infrastructure.
 */
class Connection {
    /** @var string */
    protected $host;

    /** @var Agent */
    protected $agent;

    /** @var SSH2 */
    protected $ssh;

    /**
     * Create connection to host.
     */
    public function __construct(string $host, Agent $agent) {
        $this->host = $host;
        $this->agent = $agent;
    }

    /**
     * Open the connection.
     */
    public function open(): void {
        if ($this->ssh) {
            throw new LogicException("connection already open");
        }

        $host = $this->getHost();
        $agent = $this->getAgent();
        $user = $agent->getUser();
        $key = $agent->getKey();

        $this->ssh = new SSH2($host);

        if (!$this->ssh->login($user, $key)) {
            throw new RuntimeException("could not login $user@$host");
        }
    }

    /**
     * Close the connection.
     */
    public function close(): void {
        if (!$this->ssh) {
            throw new LogicException("connection not open");
        }

        $this->ssh->disconnect();
        $this->ssh = null;
    }

    /**
     * Return true if the connection is open.
     */
    public function isOpen(): bool {
        return (bool)$this->ssh;
    }

    /**
     * Execute command.
     */
    public function execute(string $cmd): Result {
        try {
            $close = false;

            if (!$this->isOpen()) {
                $this->open();
                $close = true;
            }

            $output = $this->ssh->exec($cmd);
            $exit = $this->ssh->getExitStatus();

            return new Result($cmd, $exit, $output);
        } finally {
            if ($close) {
                $this->close();
            }
        }
    }

    /**
     * Return the user agent for the connection.
     */
    public function getAgent(): Agent {
        return $this->agent;
    }

    /**
     * Return the host used by this connection.
     */
    public function getHost(): string {
        return $this->host;
    }
}
