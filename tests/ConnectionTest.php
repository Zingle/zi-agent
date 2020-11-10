<?php

namespace Zingle\Infrastructure\Test;

use phpseclib\Net\SSH2;
use PHPUnit\Framework\TestCase;
use Zingle\Infrastructure\Agent;
use Zingle\Infrastructure\Connection;

/**
 * Class ConnectionTest
 */
class ConnectionTest extends TestCase
{
    /**
     * Test execute
     */
    public function testExecute(): void
    {
        $cmd = 'mock-cmd';
        $agent = $this->createMock(Agent::class);
        $connection = new Connection('localhost', $agent);
        $ssh = $this->createMock(SSH2::class);
        $ssh
            ->expects($this->once())
            ->method('exec')
            ->with($cmd)
            ->willReturn($mockOutput = sprintf('output-%s', rand()))
        ;
        $ssh
            ->expects($this->once())
            ->method('getExitStatus')
            ->willReturn($exitStatus = 1)
        ;
        $connection->useSsh($ssh);
        $result = $connection->execute($cmd);

        $this->assertEquals($cmd, $result->getCommand());
        $this->assertEquals($exitStatus, $result->getExit());
        $this->assertEquals($mockOutput, $result->getOutput());
    }
}
