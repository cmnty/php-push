<?php declare(strict_types = 1);

namespace Cmnty\Push;

use Psr\Http\Message\RequestInterface;

interface PushService
{
    /**
     * Check weather this push service supports a certain endpoint.
     *
     * @param Endpoint $endpoint
     *
     * @return bool
     */
    public function supportsEndpoint(Endpoint $endpoint): bool;

    /**
     * Create a push request.
     *
     * @param PushMessage $message
     *
     * @return RequestInterface
     */
    public function createRequest(PushMessage $message): RequestInterface;
}
