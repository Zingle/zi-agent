<?php

namespace Zingle\Infrastructure;

use phpseclib\Net\SSH2;
use LogicException;
use RuntimeException;

/**
 * Connection to host in Zingle infrastructure.
 */
class Connection implements ConnectionInterface
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var Agent
     */
    private $agent;

    /**
     * @var SSH2|null
     */
    private $ssh;


    /**
     * Create connection to host.
     *
     * @param string $host
     * @param Agent  $agent
     */
    public function __construct(string $host, Agent $agent)
    {
        $this->host  = $host;
        $this->agent = $agent;
    }

    /**
     * Open the connection.
     */
    public function open(): void
    {
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
     * @param SSH2 $ssh
     *
     * @return $this
     */
    public function useSsh(SSH2 $ssh): self
    {
        $this->ssh = $ssh;

        return $this;
    }

    /**
     * Close the connection.
     */
    public function close(): void
    {
        if (!$this->ssh) {
            return; // it's already closed
        }

        $this->ssh->disconnect();
        $this->ssh = null;
    }

    /**
     * @return bool true if the connection is open.
     */
    public function isOpen(): bool
    {
        return isset($this->ssh);
    }

    /**
     * Execute command.
     *
     * @param string $cmd
     *
     * @return Result
     */
    public function execute(string $cmd): Result
    {
        try {
            if (!$this->isOpen()) {
                $this->open();
            }

            $output = $this->ssh->exec($cmd);
            $exit   = (int) $this->ssh->getExitStatus();

            return new Result($cmd, $exit, $output);
        } finally {
            $this->close();
        }
    }

    /**
     * @return Agent the user agent for the connection.
     */
    public function getAgent(): Agent
    {
        return $this->agent;
    }

    /**
     * @return string the host used by this connection.
     */
    public function getHost(): string
    {
        return $this->host;
    }
}
