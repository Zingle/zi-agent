<?php

namespace Zingle\Infrastructure;


/**
 * Connection to host in Zingle infrastructure.
 */
interface ConnectionInterface
{
    /**
     * Execute command.
     *
     * @param string $cmd
     *
     * @return Result
     */
    public function execute(string $cmd): Result;
}
