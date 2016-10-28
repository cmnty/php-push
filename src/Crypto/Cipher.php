<?php declare(strict_types = 1);

namespace Cmnty\Push\Crypto;

class Cipher
{
    /**
     * @var CipherText
     */
    private $cipherText;

    /**
     * @var AuthenticationTag
     */
    private $authenticationTag;

    /**
     * @var Salt
     */
    private $salt;

    /**
     * @var PublicKey
     */
    private $publicKey;

    /**
     * Constructor.
     *
     * @param CipherText $cipherText
     * @param AuthenticationTag $authenticationTag
     * @param Salt $salt
     * @param PublicKey $publicKey
     */
    public function __construct(CipherText $cipherText, AuthenticationTag $authenticationTag, Salt $salt, PublicKey $publicKey)
    {
        $this->cipherText = $cipherText;
        $this->authenticationTag = $authenticationTag;
        $this->salt = $salt;
        $this->publicKey = $publicKey;
    }

    /**
     * Get the cypher text.
     *
     * @return CipherText
     */
    public function getCipherText()
    {
        return $this->cipherText;
    }

    /**
     * Get the authentication tag.
     *
     * @return AuthenticationTag
     */
    public function getAuthenticationTag()
    {
        return $this->authenticationTag;
    }

    /**
     * Get the salt used during encryption.
     *
     * @return Salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Get the public key
     *
     * @return PublicKey
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}
