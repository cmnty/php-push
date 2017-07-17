<?php declare(strict_types = 1);

namespace Cmnty\Push\Vapid;

use Cmnty\Push\Crypto\PublicKey;

class Token
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var PublicKey
     */
    private $publicKey;

    /**
     * Constructor.
     *
     * @param string $token
     * @param PublicKey $publicKey
     */
    public function __construct(string $token, PublicKey $publicKey)
    {
        $this->token = $token;
        $this->publicKey = $publicKey;
    }

    /**
     * Convert the token to a string.
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->token;
    }

    /**
     * Get the public key as a base64url encoded string.
     *
     * @return string
     */
    public function getPublicKeyAsBase64UrlEncodedString(): string
    {
        return $this->publicKey->getBase64UrlEncodedString();
    }
}
