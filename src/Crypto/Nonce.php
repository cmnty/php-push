<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use InvalidArgumentException;

class Nonce implements RawBytes
{
    /**
     * @var BinaryString
     */
    private $binaryString;

    /**
     * Create nonce.
     *
     * @param BinaryString $binaryString
     *
     * @throws InvalidArgumentException When the nonce is not the correct length.
     */
    public function __construct(BinaryString $binaryString)
    {
        if ($binaryString->getLength() != 12) {
            throw new InvalidArgumentException('Nonce could not be created: incorrect length.');
        }

        $this->binaryString = $binaryString;
    }

    /**
     * Get raw bytes.
     *
     * @return string
     */
    public function getRawBytes(): string
    {
        return $this->binaryString->getRawBytes();
    }
}
