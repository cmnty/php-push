<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Base64Url\Base64Url;

class BinaryString implements RawBytes
{
    /**
     * @var string
     */
    private $rawBytes;

    /**
     * Create a binary string from it's raw bytes.
     *
     * @param string $rawBytes
     */
    public function __construct(string $rawBytes)
    {
        $this->rawBytes = $rawBytes;
    }

    /**
     * Create a binary string from a base64url encoded string.
     *
     * @param string $base64UrlEncoded
     *
     * @return self
     */
    public static function createFromBase64UrlEncodedString(string $base64UrlEncoded) : self
    {
        return new self(Base64Url::decode($base64UrlEncoded));
    }

    /**
     * Get raw bytes.
     *
     * @return string
     */
    public function getRawBytes() : string
    {
        return $this->rawBytes;
    }

    /**
     * Get base64url encoded string.
     *
     * @return string
     */
    public function getBase64UrlEncodedString() : string
    {
        return Base64Url::encode($this->getRawBytes());
    }

    /**
     * Get the length of the binary string.
     *
     * @return int
     */
    public function getLength() : int
    {
        return strlen($this->getRawBytes());
    }

    /**
     * Concatenate the raw bytes with an other binary string.
     *
     * @param BinaryString $binaryString
     *
     * @return BinaryString
     */
    public function concat(BinaryString $binaryString) : BinaryString
    {
        return new BinaryString($this->getRawBytes() . $binaryString->getRawBytes());
    }

    /**
     * Slice the raw bytes to the given length.
     *
     * @param int $length
     *
     * @return BinaryString
     */
    public function slice(int $length) : BinaryString
    {
        return new BinaryString(substr($this->getRawBytes(), 0, $length));
    }
}
