<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use InvalidArgumentException;

class Salt implements RawBytes
{
    /**
     * @var BinaryString
     */
    private $binaryString;

    /**
     * Create a 16 bytes long salt.
     *
     * @throws InvalidArgumentException When the salt is not the correct length.
     */
    public function __construct()
    {
        $binaryString = new BinaryString(random_bytes(16));

        if ($binaryString->getLength() != 16) {
            throw new InvalidArgumentException('Salt could not be created: incorrect length.');
        }

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

    /**
     * Get base64url encoded string.
     *
     * @return string
     */
    public function getBase64UrlEncodedString() : string
    {
        return $this->binaryString->getBase64UrlEncodedString();
    }
}
