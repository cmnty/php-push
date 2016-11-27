<?php declare(strict_types = 1);

namespace Cmnty\Push;

interface PushMessage
{
    /**
     * Get message body.
     *
     * The message body consists of the cipher text and the authentication tag.
     *
     * @return string
     */
    public function getBody() : string;

    /**
     * Get cipher salt.
     *
     * @return string A base64url encoded representation of the salt used.
     */
    public function getSalt() : string;

    /**
     * Get the public key.
     *
     * @return string A base64url encoded representation of the public key.
     */
    public function getCryptoKey() : string;

    /**
     * Get message content length.
     *
     * @return int
     */
    public function getContentLength() : int;

    /**
     * Get message subscription.
     *
     * @return PushSubscription
     */
    public function getPushSubscription() : PushSubscription;

    /**
     * Get message ttl.
     *
     * @return int
     */
    public function getTTL() : int;
}
