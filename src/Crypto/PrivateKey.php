<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;

class PrivateKey
{
    /**
     * @var PrivateKeyInterface
     */
    private $eccKey;

    /**
     * Create a private key from a Mdanter Ecc Private Key.
     *
     * @param PrivateKeyInterface $eccKey
     *
     * @return self
     */
    public static function createFromEccKey(PrivateKeyInterface $eccKey) : self
    {
        $key = new self();
        $key->eccKey = $eccKey;

        return $key;
    }

    /**
     * Get the public key.
     *
     * @return PublicKey
     */
    public function getPublicKey() : PublicKey
    {
        return PublicKey::createFromEccKey($this->getEccKey()->getPublicKey());
    }

    /**
     * Get the private key as a Mdanter Ecc Private Key.
     *
     * @return PrivateKeyInterface
     */
    public function getEccKey() : PrivateKeyInterface
    {
        return $this->eccKey;
    }

    /**
     * Calculate a shared secret.
     *
     * @param PublicKey $publicKey The recipients public key.
     *
     * @return SharedSecret
     */
    public function calculateSharedSecret(PublicKey $publicKey) : SharedSecret
    {
        $exchange = $this->getEccKey()->createExchange($publicKey->getEccKey());
        $binary = new BinaryString(gmp_export($exchange->calculateSharedKey()));

        return new SharedSecret($binary);
    }

    /**
     * Prevent the PrivateKey from being instantiated in an invalid state.
     */
    private function __construct() {}
}
