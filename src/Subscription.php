<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Cmnty\Push\Crypto\AuthenticationSecret;
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
     * @var AuthenticationSecret
     */
    private $authenticationSecret;

    /**
     * Constructor.
     *
     * @param Endpoint $endpoint
     * @param PublicKey $publicKey
     * @param AuthenticationSecret $authenticationSecret
     */
    public function __construct(Endpoint $endpoint, PublicKey $publicKey, AuthenticationSecret $authenticationSecret)
    {
        $this->endpoint = $endpoint;
        $this->publicKey = $publicKey;
        $this->authenticationSecret = $authenticationSecret;
    }

    /**
     * Get the endpoint.
     *
     * @return Endpoint
     */
    public function getEndpoint(): Endpoint
    {
        return $this->endpoint;
    }

    /**
     * Get the endpoint host.
     *
     * @return string
     */
    public function getEndpointHost(): string
    {
        return $this->endpoint->getHost();
    }

    /**
     * Get the endpoint url.
     *
     * @return string
     */
    public function getEndpointUrl(): string
    {
        return $this->endpoint->getUrl();
    }

    /**
     * Get the endpoint registration id.
     *
     * @return string
     */
    public function getEndpointRegistrationId(): string
    {
        return $this->endpoint->getRegistrationId();
    }

    /**
     * Get the public key.
     *
     * @return PublicKey
     */
    public function getPublicKey(): PublicKey
    {
        return $this->publicKey;
    }

    /**
     * Get the authentication tag.
     *
     * @return AuthenticationSecret
     */
    public function getAuthenticationSecret(): AuthenticationSecret
    {
        return $this->authenticationSecret;
    }
}
