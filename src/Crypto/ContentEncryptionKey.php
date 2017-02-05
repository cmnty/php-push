<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use InvalidArgumentException;

class ContentEncryptionKey implements KeyingMaterial
{
    /**
     * @var BinaryString
     */
    private $binaryString;

    /**
     * Create encryption key.
     *
     * @param BinaryString $binaryString
     *
     * @throws InvalidArgumentException When the encryption key is not the correct length.
     */
    public function __construct(BinaryString $binaryString)
    {
        if ($binaryString->getLength() != 16) {
            throw new InvalidArgumentException('ContentEncryptionKey could not be created: incorrect length.');
        }

        $this->binaryString = $binaryString;
    }

    /**
     * Get raw bytes.
     *
     * @return string
     */
    public function getRawKeyMaterial(): string
    {
        return $this->binaryString->getRawBytes();
    }
}
