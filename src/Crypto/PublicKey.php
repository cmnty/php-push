<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use InvalidArgumentException;
use Mdanter\Ecc\Crypto\Key\PublicKeyInterface;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Serializer\Point\UncompressedPointSerializer;

class PublicKey implements KeyingMaterial
{
    /**
     * @var BinaryString
     */
    private $binaryString;

    /**
     * Create a public key.
     *
     * @param BinaryString $binaryString
     *
     * @throws InvalidArgumentException When the public key is not the correct length.
     */
    public function __construct(BinaryString $binaryString)
    {
        if ($binaryString->getLength() != 65) {
            throw new InvalidArgumentException('PublicKey could not be created: incorrect length.');
        }

        $this->binaryString = $binaryString;
    }

    /**
     * Create public key from a base64url encoded string.
     *
     * @param string $base64UrlEncoded
     *
     * @return self
     *
     * @throws InvalidArgumentException When the public key is not the correct length.
     */
    public static function createFromBase64UrlEncodedString(string $base64UrlEncoded) : self
    {
        return new self(BinaryString::createFromBase64UrlEncodedString($base64UrlEncoded));
    }

    /**
     * Create a public key from a Mdanter Ecc Public Key.
     *
     * @param PublicKeyInterface $eccKey
     *
     * @throws InvalidArgumentException When the public key is not the correct length.
     */
    public static function createFromEccKey(PublicKeyInterface $eccKey) : self
    {
        $math = EccFactory::getAdapter();
        $pointSerializer = new UncompressedPointSerializer($math);
        $point = $eccKey->getPoint();
        $hex = $pointSerializer->serialize($point);

        $binary = new BinaryString(hex2bin($hex));

        return new self($binary);
    }

    /**
     * Get raw bytes.
     *
     * @return string
     */
    public function getRawKeyMaterial() : string
    {
        return $this->binaryString->getRawBytes();
    }

    /**
     * Get base64url encoded string.
     *
     * @return string
     */
    public function getBase64UrlEncodedString() : string
    {
        return $this->binaryString->getBase64UrlEncodedString();
    }

    /**
     * Unserialize the raw key material into a Mdanter Ecc Public Key.
     *
     * @return PublicKeyInterface
     */
    public function getEccKey() : PublicKeyInterface
    {
        $math = EccFactory::getAdapter();
        $generator = EccFactory::getNistCurves()->generator256();
        $pointSerializer = new UncompressedPointSerializer($math);
        $point = $pointSerializer->unserialize($generator->getCurve(), bin2hex($this->getRawKeyMaterial()));

        return $generator->getPublicKeyFrom($point->getX(), $point->getY(), $generator->getOrder());
    }

    /**
     * Get the length of the public key.
     *
     * @return int
     */
    public function getLength() : int
    {
        return $this->binaryString->getLength();
    }
}
