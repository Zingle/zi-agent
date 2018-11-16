<?php

namespace Zingle\Infrastructure;
use phpseclib\Crypt\RSA;

/**
 * Zingle infrastructure user agent.
 */
class Agent {
    /** @var string */
    protected $user;

    /** @var RSA */
    protected $key;

    /**
     * Configure agent credentials.
     */
    public function __construct(string $user, string $key) {
        $keyData = $key;

        $key = new RSA();
        $key->loadKey($keyData);

        $this->user = $user;
        $this->key = $key;
    }

    /**
     * Return the agent user name.
     */
    public function getUser(): string {
        return $this->user;
    }

    /**
     * Return the agent RSA key.
     */
    public function getKey(): RSA {
        return $this->key;
    }
}
