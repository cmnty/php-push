<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Cmnty\Push\Crypto\Cipher;

class Message implements PushMessage
{
    /**
     * @var Cipher
     */
    private $cipher;

    /**
     * @var PushSubscription
     */
    private $subscription;

    /**
     * @var int
     */
    private $ttl;

    /**
     * Constructor.
     *
     * @param Cipher $cipher
     * @param PushSubscription $subscription
     * @param int $ttl
     */
    public function __construct(Cipher $cipher, PushSubscription $subscription, int $ttl = 3600)
    {
        $this->cipher = $cipher;
        $this->subscription = $subscription;
        $this->ttl = $ttl;
    }

    /**
     * Get message body.
     *
     * The message body consists of the cipher text and the authentication tag.
     *
     * @return string
     */
    public function getBody(): string
    {
        return
            $this->cipher->getRawCipherText()
            . $this->cipher->getRawAuthenticationTag()
        ;
    }

    /**
     * Get cipher salt.
     *
     * @return string A base64url encoded representation of the salt used.
     */
    public function getSalt(): string
    {
        return $this->cipher->getBase64UrlEncodedSalt();
    }

    /**
     * Get the public key.
     *
     * @return string A base64url encoded representation of the public key.
     */
    public function getCryptoKey(): string
    {
        return $this->cipher->getBase64UrlEncodedPublicKey();
    }

    /**
     * Get message content length.
     *
     * @return int
     */
    public function getContentLength(): int
    {
        return strlen($this->getBody());
    }

    /**
     * Get push subscription.
     *
     * @return PushSubscription
     */
    public function getPushSubscription(): PushSubscription
    {
        return $this->subscription;
    }

    /**
     * Get the endpoint host from the push subscription.
     *
     * @return string
     */
    public function getEndpointHost(): string
    {
        return $this->subscription->getEndpointHost();
    }

    /**
     * Get the endpoint url from the push subscription.
     *
     * @return string
     */
    public function getEndpointUrl(): string
    {
        return $this->subscription->getEndpointUrl();
    }

    /**
     * Get the endpoint registration id from the push subscription.
     *
     * @return string
     */
    public function getEndpointRegistrationId(): string
    {
        return $this->subscription->getEndpointRegistrationId();
    }

    /**
     * Get message ttl.
     *
     * @return int
     */
    public function getTTL(): int
    {
        return $this->ttl;
    }
}
