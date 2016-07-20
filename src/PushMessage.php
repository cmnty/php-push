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
    public function getBody();

    /**
     * Get cipher salt.
     *
     * @return string
     */
    public function getSalt();

    /**
     * Get cipher crypto key.
     *
     * @return string
     */
    public function getCryptoKey();

    /**
     * Get message content length.
     *
     * @return int
     */
    public function getContentLength();

    /**
     * Get message subscription.
     *
     * @return PushSubscription
     */
    public function getPushSubscription();

    /**
     * Get message ttl.
     *
     * @return int
     */
    public function getTTL();
}
