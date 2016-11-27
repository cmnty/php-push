<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use InvalidArgumentException;

class AuthenticationSecret implements RawBytes
{
    /**
     * @var BinaryString
     */
    private $binaryString;

    /**
     * Create authentication secret.
     *
     * @param BinaryString $binaryString
     *
     * @throws InvalidArgumentException When the authentication secret is not the correct length.
     */
    public function __construct(BinaryString $binaryString)
    {
        if ($binaryString->getLength() != 16) {
            throw new InvalidArgumentException('AuthenticationSecret could not be created: incorrect length.');
        }

        $this->binaryString = $binaryString;
    }

    /**
     * Create authentication secret.
     *
     * @param string $base64UrlEncoded
     *
     * @return self
     *
     * @throws InvalidArgumentException When the authentication secret is not the correct length.
     */
    public static function createFromBase64UrlEncodedString(string $base64UrlEncoded) : self
    {
        return new self(BinaryString::createFromBase64UrlEncodedString($base64UrlEncoded));
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
