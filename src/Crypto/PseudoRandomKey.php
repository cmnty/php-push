<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use InvalidArgumentException;

class PseudoRandomKey implements KeyingMaterial
{
    /**
     * @var BinaryString
     */
    private $binaryString;

    /**
     * Create pseudo random key.
     *
     * @param BinaryString $binaryString
     *
     * @throws InvalidArgumentException When the pseudo random key is not the correct length.
     */
    public function __construct(BinaryString $binaryString)
    {
        if ($binaryString->getLength() != 32) {
            throw new InvalidArgumentException('PseudoRandomKey could not be created: incorrect length.');
        }

        $this->binaryString = $binaryString;
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
}
