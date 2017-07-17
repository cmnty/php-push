<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use InvalidArgumentException;

class KeyPair
{
    /**
     * @var PrivateKey
     */
    private $private;

    /**
     * @var PublicKey
     */
    private $public;

    /**
     * Instantiate a new KeyPair from a private and public key.
     *
     * If the public key is left empty, it will be generated on demand from the private key.
     *
     * WARNING: Generating a public key from the private key is a slow process. If available, please provide both keys.
     *
     * @param PrivateKey $private
     * @param PublicKey|null $public
     */
    public function __construct(PrivateKey $private, PublicKey $public = null)
    {
        $this->private = $private;
        $this->public = $public;
    }

    /**
     * Get the private key.
     *
     * @return PrivateKey
     */
    public function getPrivateKey(): PrivateKey
    {
        return $this->private;
    }

    /**
     * Get the public key.
     *
     * @return PublicKey
     */
    public function getPublicKey(): PublicKey
    {
        if ($this->public === null) {
            $this->public = $this->private->getPublicKey();
        }

        return $this->public;
    }
}
