<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Mdanter\Ecc\Crypto\Key\PrivateKeyInterface;
use Mdanter\Ecc\Serializer\PrivateKey\DerPrivateKeySerializer;
use Mdanter\Ecc\Serializer\PrivateKey\PemPrivateKeySerializer;

class PrivateKey
{
    /**
     * @var PrivateKeyInterface|null
     */
    private $eccKey;

    /**
     * @var string|null
     */
    private $pemEncodedString;

    /**
     * Create a private key from a Mdanter Ecc Private Key.
     *
     * @param PrivateKeyInterface $eccKey
     *
     * @return self
     */
    public static function createFromEccKey(PrivateKeyInterface $eccKey): self
    {
        $key = new self();
        $key->eccKey = $eccKey;

        return $key;
    }

    /**
     * Create a private key from a PEM encoded string.
     *
     * @param string $pemEncodedString
     *
     * @return self
     */
    public static function createFromPem(string $pemEncodedString): self
    {
        $key = new self();
        $key->pemEncodedString = $pemEncodedString;

        return $key;
    }

    /**
     * Get the public key.
     *
     * WARNING: This is a slow process. Only use when the public key is not available.
     *
     * @return PublicKey
     */
    public function getPublicKey(): PublicKey
    {
        return PublicKey::createFromEccKey($this->getEccKey()->getPublicKey());
    }

    /**
     * Get the private key as a Mdanter Ecc Private Key.
     *
     * @return PrivateKeyInterface
     */
    public function getEccKey(): PrivateKeyInterface
    {
        if ($this->eccKey === null) {
            $privateKeySerializer = new PemPrivateKeySerializer(new DerPrivateKeySerializer());
            $this->eccKey = $privateKeySerializer->parse($this->pemEncodedString);
        }

        return $this->eccKey;
    }

    /**
     * Get the private key in PEM format.
     *
     * WARNING: Serializing the key is a slow process.
     *
     * @return string
     */
    public function toPem(): string
    {
        if ($this->pemEncodedString === null) {
            $keySerializer = new PemPrivateKeySerializer(new DerPrivateKeySerializer());

            $this->pemEncodedString = $keySerializer->serialize($this->getEccKey());
        }

        return $this->pemEncodedString;
    }

    /**
     * Calculate a shared secret.
     *
     * @param PublicKey $publicKey The recipients public key.
     *
     * @return SharedSecret
     */
    public function calculateSharedSecret(PublicKey $publicKey): SharedSecret
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
