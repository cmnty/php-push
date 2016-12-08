<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Cmnty\Push\Crypto\AuthenticationSecret;
use Cmnty\Push\Crypto\PublicKey;

interface PushSubscription
{
    /**
     * Get the endpoint.
     *
     * @return Endpoint
     */
    public function getEndpoint() : Endpoint;

    /**
     * Get the public key.
     *
     * @return PublicKey
     */
    public function getPublicKey() : PublicKey;

    /**
     * Get the authentication tag.
     *
     * @return AuthenticationSecret
     */
    public function getAuthenticationSecret() : AuthenticationSecret;
}
