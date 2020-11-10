<?php

namespace Zingle\Infrastructure;

use phpseclib\Crypt\RSA;

/**
 * Zingle infrastructure user agent.
 */
class Agent
{
    /**
     * @var string
     */
    private $user;

    /**
     * @var RSA
     */
    private $key;


    /**
     * Configure agent credentials.
     *
     * @param string $user
     * @param string $keyData
     */
    public function __construct(string $user, string $keyData)
    {
        $this->user = $user;
        $this->setKey($keyData);
    }

    /**
     * Return the agent user name.
     *
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * Return the agent RSA key.
     *
     * @return RSA
     */
    public function getKey(): RSA
    {
        return $this->key;
    }

    /**
     * @param string $keyData
     */
    private function setKey(string $keyData): void
    {
        $this->key = new RSA();
        $this->key->loadKey($keyData);
    }
}
