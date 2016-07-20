<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

use Base64Url\Base64Url;

class BinaryString
{
    /**
     * @var string
     */
    protected $binaryString;

    /**
     * Constructor.
     *
     * @param string $binaryString
     */
    public function __construct($binaryString)
    {
        if ((bool) preg_match('//u', $binaryString)) {
            $binaryString = Base64Url::decode($binaryString);
        }
        $this->binaryString = $binaryString;
    }

    /**
     * Get raw bytes.
     *
     * @return string
     */
    public function getRawBytes()
    {
        return $this->binaryString;
    }

    /**
     * Get base 64 url safe sting.
     *
     * @return string
     */
    public function getBase64UrlSafeString()
    {
        return Base64Url::encode($this->binaryString);
    }

    /**
     * Get the length of the key material.
     *
     * @return int
     */
    public function getLength()
    {
        return strlen($this->binaryString);
    }
}
