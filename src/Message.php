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
    public function getBody() : string
    {
        return
            $this->cipher->getCipherText()->getRawBytes()
            . $this->cipher->getAuthenticationTag()->getRawBytes()
        ;
    }

    /**
     * Get cipher salt.
     *
     * @return string A url safe base64 encoded representation of the salt used.
     */
    public function getSalt() : string
    {
        return $this->cipher->getSalt()->getBase64UrlSafeString();
    }

    /**
     * Get the public key.
     *
     * @return string A url safe base64 encoded representation of the public key.
     */
    public function getCryptoKey() : string
    {
        return $this->cipher->getPublicKey()->getBase64UrlSafeString();
    }

    /**
     * Get message content length.
     *
     * @return int
     */
    public function getContentLength() : int
    {
        return strlen($this->getBody());
    }

    /**
     * Get message subscription.
     *
     * @return PushSubscription
     */
    public function getPushSubscription() : PushSubscription
    {
        return $this->subscription;
    }

    /**
     * Get message ttl.
     *
     * @return int
     */
    public function getTTL() : int
    {
        return $this->ttl;
    }
}
