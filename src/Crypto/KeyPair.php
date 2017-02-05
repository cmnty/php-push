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
     * @param PrivateKey $private
     * @param PublicKey|null $public
     *
     * @throws InvalidArgumentException When private and public key do not match.
     */
    public function __construct(PrivateKey $private, PublicKey $public = null)
    {
        if (!$this->isValidKeyPair($private, $public)) {
            throw new InvalidArgumentException('KeyPair could not be created: private and public key do not match.');
        }

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

    /**
     * Check whether the $private key matches the public key.
     *
     * @param PrivateKey $private
     * @param PublicKey $public
     *
     * @return bool
     */
    private function isValidKeyPair(PrivateKey $private, PublicKey $public = null): bool
    {
        // If no public key was supplied, the public key will be extracted from the private key.
        if ($public === null) {
            return true;
        }

        // If the public key extracted from the private key matches the supplied public key, the pair must be valid.
        if ($private->getPublicKey() == $public) {
            return true;
        }

        return false;
    }
}
