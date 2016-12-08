<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use InvalidArgumentException;

class SharedSecret implements KeyingMaterial
{
    /**
     * @var BinaryString
     */
    private $sharedSecret;

    /**
     * Constructor.
     *
     * @param BinaryString $sharedSecret
     *
     * @throws InvalidArgumentException When the shared secret is not the correct length.
     */
    public function __construct(BinaryString $sharedSecret)
    {
        if ($sharedSecret->getLength() != 32) {
            throw new InvalidArgumentException('SharedSecret could not be created: incorrect length.');
        }

        $this->sharedSecret = $sharedSecret;
    }

    /**
     * Get raw bytes.
     *
     * @return string
     */
    public function getRawKeyMaterial() : string
    {
        return $this->sharedSecret->getRawBytes();
    }
}
