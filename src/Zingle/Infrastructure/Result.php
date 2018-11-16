<?php

namespace Zingle\Infrastructure;

/**
 * Zingle infrastructure command result.
 */
class Result {
    /** @var string */
    protected $cmd;

    /** @var int */
    protected $exit;

    /** @var string */
    protected $output;

    /**
     * Build result.
     */
    public function __construct(string $cmd, int $exit, string $output) {
        $this->cmd = $cmd;
        $this->exit = $exit;
        $this->output = $output;
    }

    /**
     * Return command which generated this result.
     */
    public function getCommand(): string {
        return $this->cmd;
    }

    /**
     * Return the command exit status.
     */
    public function getExit(): int {
        return $this->exit;
    }

    /**
     * Return the command output.
     */
    public function getOutput(): string {
        return $this->output;
    }
}
