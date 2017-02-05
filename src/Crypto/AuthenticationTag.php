<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use InvalidArgumentException;

class AuthenticationTag implements RawBytes
{
    /**
     * @var BinaryString
     */
    private $binaryString;

    /**
     * Create authentication tag.
     *
     * @param BinaryString $binaryString
     *
     * @throws InvalidArgumentException When the authentication tag is not the correct length.
     */
    public function __construct(BinaryString $binaryString)
    {
        if ($binaryString->getLength() != 16) {
            throw new InvalidArgumentException('AuthenticationTag could not be created: incorrect length.');
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
