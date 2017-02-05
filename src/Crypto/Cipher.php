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
    public function getCipherText(): CipherText
    {
        return $this->cipherText;
    }

    /**
     * Get raw cypher text.
     *
     * @return string
     */
    public function getRawCipherText(): string
    {
        return $this->cipherText->getRawBytes();
    }

    /**
     * Get the authentication tag.
     *
     * @return AuthenticationTag
     */
    public function getAuthenticationTag(): AuthenticationTag
    {
        return $this->authenticationTag;
    }

    /**
     * Get raw authentication tag.
     *
     * @return string
     */
    public function getRawAuthenticationTag(): string
    {
        return $this->authenticationTag->getRawBytes();
    }

    /**
     * Get the salt used during encryption.
     *
     * @return Salt
     */
    public function getSalt(): Salt
    {
        return $this->salt;
    }

    /**
     * Get base64url encoded salt used during encryption.
     *
     * @return Salt
     */
    public function getBase64UrlEncodedSalt(): string
    {
        return $this->salt->getBase64UrlEncodedString();
    }

    /**
     * Get the public key
     *
     * @return PublicKey
     */
    public function getPublicKey(): PublicKey
    {
        return $this->publicKey;
    }

    /**
     * Get base64url encoded public key
     *
     * @return PublicKey
     */
    public function getBase64UrlEncodedPublicKey(): string
    {
        return $this->publicKey->getBase64UrlEncodedString();
    }
}
