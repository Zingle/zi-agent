<?php

namespace Zingle\Infrastructure;

/**
 * Zingle infrastructure command result.
 */
class Result
{
    /**
     * @var string
     */
    private $cmd;

    /**
     * @var int
     */
    private $exit;

    /**
     * @var string
     */
    private $output;


    /**
     * Build result.
     *
     * @param string $cmd
     * @param int    $exit
     * @param string $output
     */
    public function __construct(string $cmd, int $exit, string $output)
    {
        $this->cmd    = $cmd;
        $this->exit   = $exit;
        $this->output = $output;
    }

    /**
     * Return command which generated this result.
     *
     * @return string
     */
    public function getCommand(): string
    {
        return $this->cmd;
    }

    /**
     * Return the command exit status.
     *
     * @return int
     */
    public function getExit(): int
    {
        return $this->exit;
    }

    /**
     * Return the command output.
     *
     * @return string
     */
    public function getOutput(): string
    {
        return $this->output;
    }
}
