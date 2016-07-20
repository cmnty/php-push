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

    public function __construct(Cipher $cipher, PushSubscription $subscription, $ttl = 3600)
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
    public function getBody()
    {
        return
            $this->cipher->getCipherText()->getRawBytes()
            . $this->cipher->getAuthenticationTag()->getRawBytes()
        ;
    }

    /**
     * Get cipher salt.
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->cipher->getSalt()->getBase64UrlSafeString();
    }

    /**
     * Get cipher crypto key.
     *
     * @return string
     */
    public function getCryptoKey()
    {
        return $this->cipher->getPublicKey()->getBase64UrlSafeString();
    }

    /**
     * Get message content length.
     *
     * @return int
     */
    public function getContentLength()
    {
        return strlen($this->getBody());
    }

    /**
     * Get message subscription.
     *
     * @return PushSubscription
     */
    public function getPushSubscription()
    {
        return $this->subscription;
    }

    /**
     * Get message ttl.
     *
     * @return int
     */
    public function getTTL()
    {
        return $this->ttl;
    }
}
