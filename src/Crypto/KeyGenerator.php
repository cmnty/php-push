<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\Math\GmpMathInterface;
use Mdanter\Ecc\Primitives\PointInterface;
use Mdanter\Ecc\Serializer\Point\UncompressedPointSerializer;

class KeyGenerator
{
    /**
     * Adapter used for math calculations
     *
     * @var GmpMathInterface
     */
    private $adapter;

    /**
     * Point generator
     *
     * @var PointInterface
     */
    private $generator;

    /**
     * Initialize a new exchange from a generator point.
     *
     * @param GmpMathInterface $adapter A math adapter instance.
     * @param PointInterface $generator A point generator instance.
     */
    public function __construct(GmpMathInterface $adapter, PointInterface $generator)
    {
        $this->adapter = $adapter;
        $this->generator = $generator;
        $this->pointSerializer = new UncompressedPointSerializer($this->adapter);
    }

    /**
     * Create a PublicKeyInterface from a EncryptionKey
     *
     * @param PublicKey $publicKey
     *
     * @return PublicKeyInterface
     */
    public function generatePublicKey(PublicKey $publicKey)
    {
        $point = $this->pointSerializer->unserialize($this->generator->getCurve(), bin2hex($publicKey->getRawBytes()));

        return $this->generator->getPublicKeyFrom($point->getX(), $point->getY(), $this->generator->getOrder());
    }

    /**
     * Convert a Mdanter Ecc PublicKeyInterface into a PublicKey
     *
     * @param PublicKeyInterface $publicKey
     *
     * @return PublicKey
     */
    public function convertPublicKey(PublicKeyInterface $publicKey)
    {
        return new PublicKey(hex2bin($this->pointSerializer->serialize($publicKey->getPoint())));
    }
}
