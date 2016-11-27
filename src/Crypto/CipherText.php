<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

class CipherText implements RawBytes
{
    /**
     * @var BinaryString
     */
    private $binaryString;

    /**
     * Create cipher text.
     *
     * @param BinaryString $binaryString
     */
    public function __construct(BinaryString $binaryString)
    {
        $this->binaryString = $binaryString;
    }

    /**
     * Get raw bytes.
     *
     * @return string
     */
    public function getRawBytes() : string
    {
        return $this->binaryString->getRawBytes();
    }
}
