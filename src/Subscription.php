<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Cmnty\Push\Crypto\AuthenticationTag;
use Cmnty\Push\Crypto\PublicKey;

class Subscription implements PushSubscription
{
    /**
     * @var Endpoint
     */
    private $endpoint;

    /**
     * @var PublicKey
     */
    private $publicKey;

    /**
     * @var AuthenticationTag
     */
    private $authenticationTag;

    /**
     * Constructor.
     *
     * @param Endpoint $endpoint
     * @param PublicKey $publicKey
     * @param AuthenticationTag $authenticationTag
     */
    public function __construct(Endpoint $endpoint, PublicKey $publicKey, AuthenticationTag $authenticationTag)
    {
        $this->endpoint = $endpoint;
        $this->publicKey = $publicKey;
        $this->authenticationTag = $authenticationTag;
    }

    /**
     * Get the endpoint.
     *
     * @return Endpoint
     */
    public function getEndpoint() : Endpoint
    {
        return $this->endpoint;
    }

    /**
     * Get the public key.
     *
     * @return PublicKey
     */
    public function getPublicKey() : PublicKey
    {
        return $this->publicKey;
    }

    /**
     * Get the authentication tag.
     *
     * @return AuthenticationTag
     */
    public function getAuthenticationTag() : AuthenticationTag
    {
        return $this->authenticationTag;
    }
}
