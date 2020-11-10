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
     * @param string   $user
     * @param RSA|null $key
     */
    public function __construct(string $user, RSA $key = null)
    {
        $this->user = $user;
        $this->key  = $key;
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
     * @param RSA $key
     *
     * @return $this
     */
    public function setKey(RSA $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param string $keyData
     */
    public function setKeyFromData(string $keyData): void
    {
        $this->key = new RSA();
        $this->key->loadKey($keyData);
    }
}
