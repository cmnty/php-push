<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Cmnty\Push\Crypto\AuthenticationTag;
use Cmnty\Push\Crypto\PublicKey;

interface PushSubscription
{
    /**
     * Get the endpoint.
     *
     * @return Endpoint
     */
    public function getEndpoint();

    /**
     * Get the public key.
     *
     * @return PublicKey
     */
    public function getPublicKey();

    /**
     * Get the authentication tag.
     *
     * @return AuthenticationTag
     */
    public function getAuthenticationTag();
}
